<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoginCheck;

class IndexController extends Controller
{
    protected $userId = null;

    public function index(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        return view('index.index', []);
    } //end index function

    public function maincontent(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);

        return view('index.maincontent', []);
    } //end maincontent function

    public function menu(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);

        return view('index.menu', []);
    } //end menu function

    public function dashboard(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);

        $crsnum = trim($request->input('crsnum'));
        $msg = trim($request->input('msg'));

        return view('index.dashboard', compact('crsnum', 'msg'));
    } //end dashboard function

} //end class IndexController
