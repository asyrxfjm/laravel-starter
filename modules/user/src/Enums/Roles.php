<?php

namespace Modules\User\Enums;

enum Roles: string
{
    case SuperAdmin = 'Super Admin';
    case Admin = 'Admin';
    case User = 'User';
}
