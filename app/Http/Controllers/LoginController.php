<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
            
        ]);
        if($validator->passes()){
            if(Auth::attempt(['email' => $request->email,'password'=>$request->password])){
                return redirect()->route('account.dashboard')->with('Enter email or Password is incorrect');

            }else{
                return redirect()->route('account.login')->with('error','Enter email or Password is incorrect');
            }
    }else {
        return redirect()->route('account.login')->withInput()->withErrors($validator);
    }

}

public function register(){
 
     return view('register');
}

public function processRegister(Request $request){
    $validator = Validator::make($request->all(),[
        'email'=>'required|email|unique:users,email',
        'password'=>'required|confirmed'
        
    ]);
    if($validator->passes()){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'customer';
        $user->save();
        
        return redirect()->route('account.login')->with('success','You have registed successfully');

     
     }else {
    return redirect()->route('account.register')->withInput()->withErrors($validator);
     }
 }
 public function logout(){
    Auth::logout();
    return redirect()->route('account.login');
 }

}

