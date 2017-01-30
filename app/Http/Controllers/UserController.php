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
        $srchCsl = trim($request->input('srchCsl'));;
        $userModel = new User(); //model
        $toolModel = new Tool(); //model
        $usersData = json_encode($userModel->getUsersByNameOrCsl($srchName, $srchCsl));
        $toolsData = json_encode($toolModel->getAllTools());
        $permissionsData = json_encode($userModel->getAllUsersPermissions($srchName, $srchCsl));

        return view('user.index', compact('usersData', 'toolsData', 'permissionsData', 'srchName', 'srchCsl'));

    } //end index

    public function searchUser(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);

        echo "Search user permissions results";
    } //end searchUser

} //end UserController class
