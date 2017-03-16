<?php

/*

    Copyright (c) 2009-2017 F3::Factory/Bong Cosca, All rights reserved.

    This file is part of the Fat-Free Framework (http://fatfreeframework.com).

    This is free software: you can redistribute it and/or modify it under the
    terms of the GNU General Public License as published by the Free Software
    Foundation, either version 3 of the License, or later.

    Fat-Free Framework is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
    General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with Fat-Free Framework.  If not, see <http://www.gnu.org/licenses/>.

*/

//! Generic array utilities
class Matrix extends Prefab
{
    /**
     *	Retrieve values from a specified column of a multi-dimensional
     *	array variable.
     *
     *	@return array
     *
     *	@param $var array
     *	@param $col mixed
     **/
    public static function pick(array $var, $col)
    {
        return array_map(
            function ($row) use ($col) {
                return $row[$col];
            },
            $var
        );
    }

    /**
     *	Rotate a two-dimensional array variable.
     *
     *	@param $var array
     **/
    public static function transpose(array &$var)
    {
        $out = [];
        foreach ($var as $keyx => $cols) {
            foreach ($cols as $keyy => $valy) {
                $out[$keyy][$keyx] = $valy;
            }
        }
        $var = $out;
    }

    /**
     *	Sort a multi-dimensional array variable on a specified column.
     *
     *	@return bool
     *
     *	@param $var array
     *	@param $col mixed
     *	@param $order int
     **/
    public static function sort(array &$var, $col, $order = SORT_ASC)
    {
        uasort(
            $var,
            function ($val1, $val2) use ($col, $order) {
                list($v1, $v2) = [$val1[$col], $val2[$col]];
                $out = is_numeric($v1) && is_numeric($v2) ?
                    Base::instance()->sign($v1 - $v2) : strcmp($v1, $v2);
                if ($order == SORT_DESC) {
                    $out = -$out;
                }

                return $out;
            }
        );
        $var = array_values($var);
    }

    /**
     *	Change the key of a two-dimensional array element.
     *
     *	@param $var array
     *	@param $old string
     *	@param $new string
     **/
    public static function changekey(array &$var, $old, $new)
    {
        $keys = array_keys($var);
        $vals = array_values($var);
        $keys[array_search($old, $keys)] = $new;
        $var = array_combine($keys, $vals);
    }

    /**
     *	Return month calendar of specified date, with optional setting for
     *	first day of week (0 for Sunday).
     *
     *	@return array
     *
     *	@param $date string
     *	@param $first int
     **/
    public static function calendar($date = 'now', $first = 0)
    {
        $out = false;
        if (extension_loaded('calendar')) {
            $parts = getdate(strtotime($date));
            $days = cal_days_in_month(CAL_GREGORIAN, $parts['mon'], $parts['year']);
            $ref = date('w', strtotime(date('Y-m', $parts[0]).'-01')) + (7 - $first) % 7;
            $out = [];
            for ($i = 0;$i < $days;++$i) {
                $out[floor(($ref + $i) / 7)][($ref + $i) % 7] = $i + 1;
            }
        }

        return $out;
    }

		public static function force($value)
    {
        if (!is_array($value)) {
            return array($value);
        }

        return $value;
    }

    public static function value($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }
        $keys = self::force($key);

        // short-circuit
        if (!is_array($array)) {
            return self::resolve($default);
        }

        // a flag to remember whether something has been found or not
        $found = false;

        // To retrieve the array item using dot syntax, we'll iterate through
        // each segment in the key and look for that value. If it exists, we
        // will return it, otherwise we will set the depth of the array and
        // look for the next segment.
        foreach ($keys as $key) {
            foreach (explode(':', $key) as $segment) {
                if (!is_array($array) || !array_key_exists($segment, $array)) {
                    // did we not find something? mark `found` as `false`
                    $found = false;
                    break;
                }

                // we found something, although not sure if this is the last thing,
                // mark `found` as `true` and let the outer loop handle it if this
                // *is* the last thing in the list
                $found = true;
                $array = $array[$segment];
            }

            // if `found` is `true`, the inner loop found something worth returning,
            // which means that we're done here
            if ($found) {
                break;
            }
        }

        if ($found) {
            // `found` is `true`, we found something, return that
            return $array;
        } else {
            // `found` isn't `true`, return the default
            return self::resolve($default);
        }
    }

    public static function search($array, $key, $value) {
        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                return $array;
            }
            foreach ($array as $subarray) {
                return $subarray;
            }
        }
        return false;
    }

    public static function resolve($value)
    {
        return (is_callable($value) && !is_string($value)) ? call_user_func($value) : $value;
    }

    public static function nest($source, $identifier = 'parent', $children = 'children')
    {

        $nested = array();
        foreach ($source as &$s) {
            if (is_null($s[$identifier]) || !$s[$identifier]) {
                // no $identifier so we put it in the root of the array
                $nested[] = &$s;
            } else {
                $pid = $s[$identifier];
                if (isset($source[$pid])) {
                    // If the parent ID exists in the source array
                    // we add it to the 'children' array of the parent after initializing it.
                    if (!isset($source[$pid][$s['type']])) {
                        $source[$pid][$s['type']] = array();
                    }

                    $source[$pid][$s['type']][] = &$s;
                }
            }
        }
        return $nested;
    }
}
