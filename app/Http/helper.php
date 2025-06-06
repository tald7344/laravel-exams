<?php


/*
    Admin Helper Functions
    --------------------------------------
*/


// helper function for url() function
if (!function_exists('aurl')) {
    // aurl(admin url) function will rewrite url function to add (admin/) route automatically to it without writed it
    function aurl($url = null)
    {
        return url('admin/' . $url);
    }
}

// admin helper function to call 'auth()->guard('admin')' guard direct
if (!function_exists('admins')) {
    function admins()
    {
        return auth()->guard('admins');
    }
}


// users helper function to call 'auth()->guard('web')' guard direct
if (!function_exists('users')) {
    function users() {
        // THis Guard fetch from 'config/auth.php' file
        return auth()->guard('web');
    }
}


// function to check if the route is for admin or user and activate the menu for it
if (!function_exists('activate_menu')) {
    function activate_menu($link, $level = 'admin') {
        if ( $level == 'admin' ) {
            /*
                - Request::segment() = request()->segment() : it's catch the url (http://localhost:8000/admin/user)
                    and bring us (admin/user), so will be [ segment(1) == admin & segment(2) == user]
            */
            if (empty($link) && request()->segment(2) == '' && request()->segment(1) == 'admin') {
                return ['', 'active', 'display:block;'];
            }
            if (!empty($link) && preg_match('/' . $link . '/i', request()->segment(2)) && is_null(request()->segment(3))) {
                return ['menu-open', 'active', 'display:block;'];
            } else {
                return ['', '', ''];
            }
        } else {
            if (preg_match('/' . $link . '/i', request()->segment(1))) {
                return ['active'];
            } else {
                return [''];
            }
        }
    }
}


// admin helper
if (!function_exists('lang')) {
    function lang() {
        if (session()->has('lang')) {
            return session('lang');
        } else {
            return session()->put('lang', 'en');
        }
    }
}


// admin helper function for direction ltr/rtl
if (!function_exists('direction')) {
    function direction() {
         if (session()->has('lang')) {
            if (lang() == 'ar') {
                return 'rtl';
            } else {
                return 'ltr';
            }
         } else {
             return 'rtl';
         }
    }
}

if (! function_exists('words')) {
    function words($value, $words = 100, $end = '...')
    {
        return \Illuminate\Support\Str::words($value, $words, $end);
    }
}


if (! function_exists('getBreadcrumbWord')) {
    function getBreadcrumbWord()
    {
        $arr = explode('/', request()->getRequestUri());
        $string = '';
        // remove all parameter before (admin) word
        foreach($arr as $key => $item) {
            if ($item != 'admin') {
                unset($arr[$key]);
            } else {
                break;
            }
        }
        // Reindex the array
        $newArr = $array = array_values($arr);
        unset($newArr[0]);                      // Remove (admin) value
        $newArrCount = count($newArr);
        if (empty($newArr)) return '';
        // remove last item from array if its a number
        if (is_numeric($newArr[$newArrCount])) unset($newArr[$newArrCount]);
        for($key = 1; $key <= count($newArr); $key++) {
            $newKey = $key;
            // remove any item from array if it's a number
            if (is_numeric($newArr[$key])) {
                unset($newArr[$key]);
                $newKey = $key + 1;
            }
            $class = count($newArr) == $newKey ? 'active' : '';
            // added route
            $url = $newKey === 1 ? route($newArr[$newKey] . '.index') : '';
            if (!empty($url) && count($newArr) > 1 && !is_numeric($newArr[count($newArr)])) {
                $string .= '<li class="breadcrumb-item '. $class . '"><a href="'.$url.'">' . ucwords(trans('admin.' . $newArr[$newKey])) . '</a></li>' ;
            } else {
                $newKey = count($newArr) === 1 ? 1 : $newKey;
                $string .= '<li class="breadcrumb-item '. $class . '">' . ucwords(trans('admin.' . $newArr[$newKey])) . '</li>' ;
            }
        }
        return $string;
    }
}
