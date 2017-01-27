<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class LoginCheck extends Model
{
    public static function isLoggedIn(Request $request) {
        $userId = $request->session()->has('userId') ? $request->session()->get('userId') : null;
        if(!($userId > 0)) {
            $response = redirect()->route('login',['msg'=>'Please login']);
            $request->session()->flush();
            $request->session()->regenerate(true);
            $response->send();
            exit;
        } //end if
        return $userId;
    } //end isLoggedIn

} //end LoginCheck Class
