<?php namespace App\Http\Controllers;

use Auth;
use Input;
use Illuminate\Support\Facades\Redirect;

class AuthController extends BaseController{

    public function getLogin()
    {
        return \View::make('login');
    }

    public function postLogin()
    {
        if(Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')))){
               return Redirect::intended('/');
        }else{
            return Redirect::to('/login')
                ->with('error','You dont have access permission, sorry.');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/login');
    }


}