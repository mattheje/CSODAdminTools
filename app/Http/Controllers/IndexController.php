<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\LoginCheck;
use App\LoNumber;

class IndexController extends Controller
{
    protected $userId = null;

    public function index(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        $msg = $request->input('msg');
        $bburl = trim($request->input('bburl'));
        return view('index.index', compact('msg', 'bburl'));
    } //end index function

    public function maincontent(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        $msg = $request->input('msg');
        $bburl = trim($request->input('bburl'));
        return view('index.maincontent', compact('msg', 'bburl'));
    } //end maincontent function

    public function menu(Request $request) {
        $this->userId = LoginCheck::isLoggedIn($request);
        return view('index.menu', []);
    } //end menu function

    public function dashboard(Request $request, $type = null) {
        $this->userId = LoginCheck::isLoggedIn($request);

        $crsnum = trim($request->input('crsnum'));
        $msg = trim($request->input('msg'));
        $loId = $request->input('loId');
        $loAction = trim($request->input('loAction'));

        if($loAction == 'R' && $loId > 0 && in_array('lonumadminedit',$request->session()->get('userpermissions'))) {
            $loModel = new LoNumber();
            $loModel->unLockLmsLoNumber($loId);
            $msg = "LO/Course Number Successfully Released!";
        } //end if

        return view('index.dashboard', compact('crsnum', 'msg', 'type'));
    } //end dashboard function

    public function construction() {
        return view('index.construction', []);
    } //end construction

} //end class IndexController
