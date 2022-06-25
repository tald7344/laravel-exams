<?php

use Illuminate\Support\Facades\Storage;

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
            if (preg_match('/' . $link . '/i', request()->segment(2))) {
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
