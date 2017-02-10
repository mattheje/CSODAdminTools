<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tool;
use App\LoginCheck;

class UserController extends Controller
{
    protected $userId = null;

    public function index (Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        $srchName = trim($request->input('srchName'));
        $srchCsl = trim($request->input('srchCsl'));
        $srchImprt = $request->input('srchImprt',0);
        $action = strtoupper(trim($request->input('userAction')));
        $actionUserId = trim($request->input('userActionUserID'));
        $allParams = $request->all();
        $permissions = array();
        foreach($allParams as $key => $value) {
            $prefix = 'permission_' . $actionUserId . '_';
            $pos = strpos(trim($key), $prefix);
            if ($pos === 0 && $value == '1') $permissions[] = substr(trim($key), strlen($prefix));
        } //end foreach

        $userModel = new User(); //model
        $toolModel = new Tool(); //model
        $msg = null;
        switch($action) {
            case 'I':
                $status = $userModel->importUserFromLdap($actionUserId, $request->session()->get('username'));
                if($status !== false) $msg = "User Successfully Imported From LDAP";
                break;
            case 'E':
                $status = $toolModel->resetUserPermissions($actionUserId, $permissions, $request->session()->get('username'));
                if($status !== false) $msg = "User Permissions Successfully Updated";
                break;
            case 'D':
                $status = $userModel->deactivateUser($actionUserId, $request->session()->get('username'));
                if($status !== false) $msg = "User Successfully De-Activated";
                break;
            case 'R':
                $status = $userModel->reactivateUser($actionUserId, $request->session()->get('username'));
                if($status !== false) $msg = "User Successfully Re-Activated";
                break;
        } //end switch

        $usersData = $userModel->getUsersByNameOrCsl($srchName, $srchCsl);
        $ldapData = $userModel->searchFAluLdapForUser($srchName, $srchCsl, $srchImprt, $usersData);
        $usersData = json_encode(array_merge($ldapData,$usersData));
        $toolsData = json_encode($toolModel->getAllTools());
        $permissionsData = json_encode($userModel->getAllUsersPermissions($srchName, $srchCsl));

        return view('user.index', compact('usersData', 'toolsData', 'permissionsData', 'srchName', 'srchCsl', 'srchImprt', 'msg'));

    } //end index

} //end UserController class
