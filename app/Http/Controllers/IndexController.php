<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoginCheck;
use App\LoNumber;

class IndexController extends Controller
{
    protected $userId = null;

    public function index(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        $msg = $request->input('msg');
        return view('index.index', compact('msg'));
    } //end index function

    public function maincontent(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        $msg = $request->input('msg');
        return view('index.maincontent', compact('msg'));
    } //end maincontent function

    public function menu(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        return view('index.menu', []);
    } //end menu function

    public function dashboard(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);

        $crsnum = trim($request->input('crsnum'));
        $msg = trim($request->input('msg'));
        $loId = $request->input('loId');
        $loAction = trim($request->input('loAction'));

        if($loAction == 'R' && $loId > 0) {
            $loModel = new LoNumber();
            $loModel->unLockLmsLoNumber($loId);
            $msg = "LO/Course Number Successfully Released!";
        } //end if

        return view('index.dashboard', compact('crsnum', 'msg'));
    } //end dashboard function

} //end class IndexController
