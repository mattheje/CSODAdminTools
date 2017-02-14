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

    public static function isLoggedInHasPermissions(Request $request, array $requiredPermissions = array()) {
        $userId = $request->session()->has('userId') ? $request->session()->get('userId') : null;
        if(!($userId > 0)) {
            $response = redirect()->route('login',['msg'=>'Please login', 'bburl'=>'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']]);
            $request->session()->flush();
            $request->session()->regenerate(true);
            $response->send();
            exit;
        } //end if

        $userPermissions = $request->session()->has('userpermissions') ? $request->session()->get('userpermissions') : array();
        $requiredPermissions = (is_array($requiredPermissions)) ? $requiredPermissions : array();
        foreach($requiredPermissions as $requiredPermission) { //All Permissions Required
            if(!(in_array($requiredPermission,$userPermissions))) {
                $response = redirect()->route('dashboard',['msg'=>'Invalid User Permissions For This Tool!']);
                $response->send();
                exit;
            } //end if
        } //end foreach

        return $userId;
    } //isLoggedInHasPermissions

} //end LoginCheck Class
