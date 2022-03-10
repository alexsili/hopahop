<?php

namespace App\Http\Controllers;

use App\Lib\Helper;
use App\SystemPackages;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $loggedUser;

    public function __construct()
    {
//        $this->middleware('auth');
        $this->middleware(function (Request $request, $next) {
            $this->loggedUser = Auth::user();

            if(isset($this->loggedUser->type)) {


                if ($request->segment(1) != 'api' && $this->loggedUser->type != 'webuser') {
                    Auth::logout();
                    abort(401, 'Sorry! You are not authorized to access this page.');
                }
            }

            //$bellCounter = Helper::notificationsCountPerUser();
            $bellCounter = [1 => 12];

            View::share('loggedUser', $this->loggedUser);
            View::share('bellCounter', $bellCounter);

            return $next($request);
        });
    }
}
