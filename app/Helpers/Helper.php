<?php
/**
 * PHP Version 8.1.11
 * Laravel Framework 9.43.0
 *
 * @category Helper
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 11/12/22
 * */

namespace App\Helpers;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;


class Helper
{
    public static function getTarget($target): string
    {
        if ($target == 0) {
            return '_self';
        } else {
            return '_blank';
        }
    }

    /**
     * JSON String to php array conversion
     *
     * @return mixed
     */
    public static function convertJson($menus)
    {
        return json_decode($menus, true);
    }

    /**
     * @param int|string|null $route_id
     */
    public static function getRoute(string $route, $route_id = null): string
    {
        try {
            return route($route, $route_id);
        } catch (RouteNotFoundException $e) {
            return '';
        }
    }

    /**
     * @return mixed|string
     */
    public static function getFirstRoute(string $route)
    {
        $routeArray = explode('.', $route);

        return $routeArray[0];
    }

    /**
     * Determines if select box or checkbox is selected.
     *
     * @param int|string $value The value
     * @param int|string $old The old
     * @param int|string $edit_value The edit value
     * @param string $type The type
     * @return bool      True if selected, False otherwise.
     */
    public static function isSelected($value, $old, $edit_value = null, string $type = 'select')
    {
        try {
            if (!is_array($edit_value)) {
                if ($edit_value) {
                    if ($value == $edit_value) {
                        return $type == 'select' ? 'selected' : 'checked';
                    }
                } else {
                    if ($value == $old) {
                        return $type == 'select' ? 'selected' : 'checked';
                    }
                }
            } else {
                if (in_array($value, $edit_value)) {
                    return $type == 'select' ? 'selected' : 'checked';
                }
            }
        } catch (Throwable $e) {
            report($e);

            return false;
        }
    }
}
