<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CookiesController extends Controller
{
    public function setCookie()
    {
        $response = response('Hello');
        $response->withCookie('cookie_consent', Str::uuid(), 1);
        return $response;
    }

    public function getCookie()
    {
        return request()->cookie('cookie_consent');
    }

    public function deleteCookie()
    {
        return response('deleted')->cookie('cookie_consent', null, -1);
    }
}
