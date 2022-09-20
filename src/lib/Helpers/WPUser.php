<?php

namespace Masteryl\Helpers;

class WPUser
{
    public static function hasRole($user, $roles)
    {
        if (is_string($roles)) {
            $roles = [];
        }

        foreach ($roles as $role) {
            if (!empty($user->caps[$role])) {
                return true;
            }
        }

        return false;

    }

    public static function isAdmin($user)
    {
        return !empty($user->caps['administrator']);
    }
}
