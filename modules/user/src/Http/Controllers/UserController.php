<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Department\Models\Department;
use Modules\User\Enums\Roles;
use Modules\User\Http\Requests\StoreRequest;
use Modules\User\Http\Requests\UpdateRequest;
use Modules\User\Models\Role;
use Modules\User\Models\User;

class UserController extends Controller
{
    public function index(): Response
    {
        /** @var LengthAwarePaginator */
        $query = User::query()
            ->with('roles')
            ->when(request('search'), function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', '%' . request('search') . '%')
                        ->orWhere('email', 'like', '%' . request('search') . '%')
                        ->orWhere('id', request('search'));
                });
            })
            ->when(request('sort'), function ($query) {
                return $query->orderBy(request('sortBy'), request('sort'));
            })
            ->where('email', '!=', Auth::user()->email)
            ->paginate();

        return Inertia::render('Users/Index', [
            'users' => $query->withQueryString(),
            'filters' => request()->only(['search', 'sort', 'sortBy', 'page']),
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Users/Create', [
            'selectedRole' => $request->input('role'),
            'roles' => Role::whereNot('name', Roles::SuperAdmin->value)->get()->pluck('name'),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = User::create($request->validated() + ['password' => bcrypt(Str::random(16))]);

        $user->syncRoles($request->input('role'));

        Session::flash('message', 'User created successfully.');

        if ($request->has('role')) {
            $lowerRole = Str::lower($request->input('role'));

            return to_route("users.$lowerRole.index");
        }

        return to_route('users.index');
    }

    public function edit(User $user): Response
    {

        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(User $user, UpdateRequest $request): RedirectResponse
    {
        $user->update($request->validated());

        return back();
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        Session::flash('message', 'User deleted successfully.');

        return to_route('users.index');
    }

    public function setUserDepartment(User $user, Request $request): RedirectResponse
    {
        $user->update(['unit_id' => $request->input('unit_id')]);

        return back();
    }
}
