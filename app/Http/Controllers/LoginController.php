<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function index(Request $request) {
        $request->session()->regenerate(true);
        $defaultUsername = isset($_COOKIE['lng_username']) ? trim($_COOKIE['lng_username']) : null;
        return view('login.index', compact('defaultUsername'));
    } //end index function


    public function login(Request $request) {
        $this->validate($request, ['username' => 'bail|required|min:2',
                                   'password' => 'required|min:2']); //validate
        $userModel = new User(); //model
        $username = strtolower(trim($request->input('username')));
        $password = trim($request->input('password'));

        $userId = $userModel->authenticate($username, $password);
        if ($userId > 0) { //successful login
            $userData = $userModel->getUserById($userId);
            if($userData->status != 1) { //but a de-activated account
                $request->session()->flush();
                $request->session()->regenerate(true);
                $response = redirect()->route('login',['msg'=>'This User Account has been De-Activated.  Please Contact an Administrator']);
                $response->send();
                exit;
            } //end if
            $request->session()->put('userId', $userId);
            $request->session()->put('username', $username);
            $request->session()->put('fullname', $userData->fname . ' '. $userData->lname);
            $request->session()->put('useremail', $userData->email);
            $response = redirect()->route('index', ['msg' => 'Welcome ' . $userData->fname . '!'])
                                  ->withCookie(cookie('lng_username', $username, 1051200)); //2 Years (in minutes)
            $request->session()->save();
            $response->send();
            exit;
        } else { //failed login
            $msg = ($userId === -1) ? 'LDAP Connection Could Not Be Made' : 'Invalid Username or Password';
            $request->session()->flush();
            $request->session()->regenerate(true);
            $response = redirect()->route('login',['msg'=>$msg]);
            $response->send();
            exit;
        } //end if
    } //end login function


    public function logout(Request $request) {
        $msg = $request->input('msg','You have been successfully logged out.');
        $request->session()->flush();
        $request->session()->regenerate(true);
        $response = redirect()->route('login',['msg'=>$msg]);
        $response->send();
        exit;
    } //end logout function


} //end class LoginController
