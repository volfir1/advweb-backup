<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Hash;

class AuthController extends Controller
{
    //
    public function login(){
        return view('auth.login');
    }

    public function signup(){
        return view('auth.signup');
    }

    public function registerUser(Request $request){
       
        
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' =>'required|string|min:3|max:12',
        'terms' => 'accepted', // 'accepted' ensures the checkbox is checked
    ], [
        'terms.accepted' => 'You must agree to the Terms & Conditions.', // Custom error message for terms checkbox
    ]);

    $user = new User;

    $user->name= $request->name;
    $user->email= $request->email;
    $user->password=  Hash::make($request->password);
    
    $res =$user->save();

    if($res){
        return back()-> with('success', 'You have finally registered');
    }else{
        return back()-> with('failed', 'Something went wrong, pleasse try again');
    }

    }
    
  
    
    public function authenticate(Request $request)
    {
        // Validate the input
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'], // Adjust 'max' as needed
            'password' => ['required'],
        ]);
    
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent fixation attacks
            $request->session()->regenerate();
    
            // Redirect to the intended page
            return response()->json(['success' => true]);
        }
    
        // If authentication fails, redirect back with an error message
        return response()->json(['success' => false, 'message' => 'The provided credentials do not match our records.']);
    }
    


}
