<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SetAuthCookieController extends Controller
{
    public function set(Request $request){

        $loginType = filter_var(request('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($loginType, '=', $request->email)->first();

        $userLog = new UserLog();

        $userLog->user_id = $user->id;
        $userLog->token = $request->access_token;
        $userLog->token_type = $request->token_type;
        $userLog->expires_in = $request->expires_in;
        $userLog->expires_on = date("Y-m-d H:i:s", strtotime("+$request->expires_in sec"));

        $userLog->save();

        if (!$userLog->exists) {
            return response()->json(array('result' => false, 'response' => array('type' => 0, 'msg' => 'Terjadi kesalahan saat mengolah data')));
        }

        Cookie::queue('user_token', $request->access_token, $request->expires_in);
        Cookie::queue('user_fullname', $user->name, $request->expires_in);

        // everything good, return success response
        return response()->json(array('result' => true, 'response' => array('type' => 0, 'msg' => 'Sukses')));

    }
}
