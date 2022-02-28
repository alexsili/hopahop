<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DeveloperController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public static function changeUserRole($role)
    {
        $user  = User::find(auth()->user()->id);
        $roles = ['author','reviewer','editor','developer'];

        if (!in_array($role, $roles)) {
            dd('Cannot find role! Choose from: ', $roles);
        }

        $user->roles = $role;
        $user->save();
    }

    public static function resetDB()
    {
        if(env('APP_ENV') == 'master') {
            dd('You are on live server!');
        }

        try {

            DB::table('submissions')->truncate();
            DB::table('submission_reviewers')->truncate();
            DB::table('submission_files')->truncate();
            DB::table('submission_authors')->truncate();
            DB::table('chat_messages')->truncate();
            DB::table('notifications')->truncate();
            DB::table('notifications_receipts')->truncate();


        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
