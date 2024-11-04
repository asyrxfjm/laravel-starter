<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;
use Modules\User\Enums\Roles;
use Modules\User\Models\User;

class AdminController extends Controller
{
    public function index(): Response
    {
        /** @var LengthAwarePaginator */
        $query = User::query()
            ->role(Roles::Admin->value)
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

        return Inertia::render('Users/Admin/Index', [
            'users' => $query->withQueryString(),
            'filters' => request()->only(['search', 'sort', 'sortBy', 'page']),
            'message' => Session::get('message'),
            'error' => Session::get('error'),
        ]);
    }
}
