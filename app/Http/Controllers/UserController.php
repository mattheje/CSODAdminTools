<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\LoginCheck;

class UserController extends Controller
{
    protected $userId = null;

    public function index (Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        $srchName = trim($request->input('srchName'));
        $srchCsl = trim($request->input('srchCsl'));;
        $userModel = new User(); //model
        $usersData = $userModel->getUsersByNameOrCsl($srchName, $srchCsl);

        return view('user.index', compact('usersData', 'srchName', 'srchCsl'));

    } //end index

    public function searchUser(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);

        echo "Search user permissions results";
    } //end searchUser

} //end UserController class
