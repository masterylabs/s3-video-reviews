<?php

namespace Masteryl\Helpers;

class WPGetter
{
    public static function roles($meta = null)
    {
        if (!function_exists('get_editable_roles')) {
            require_once ABSPATH . '/wp-admin/includes/user.php';
        }
        $roles = get_editable_roles();

        if (is_string($meta) && $meta == 'raw') {
            return $roles;
        }

        $items = [];

        foreach ($roles as $key => $role) {
            $entry = [
                'text' => $role['name'],
                'value' => $key,
            ];

            if ($meta) {
                $entry['meta'] = $role;
            }

            $items[] = $entry;
        }

        return $items;
    }
}
