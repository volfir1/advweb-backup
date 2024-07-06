<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function signup()
    {
        return view('auth.signup');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:3|max:12',
            
        ], [
            
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $res = $user->save();

        if ($res) {
            return back()->with('success', 'You have successfully registered');
        } else {
            return back()->with('failed', 'Something went wrong, please try again');
        }
    }

    public function authenticate(Request $request)
    {
        // Validate the input
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent fixation attacks
            $request->session()->regenerate();
    
            // Redirect based on user role
            $user = Auth::user();
            if ($user->is_admin) {
                return response()->json(['success' => true, 'redirect' => route('admin.index')]);
            } else {
                return response()->json(['success' => true, 'redirect' => route('customer.menu.dashboard')]);
            }
        }
    
        // If authentication fails, return error message
        return response()->json(['success' => false, 'message' => 'The provided credentials do not match our records.']);
    }
    
    public function logout(){
        auth()->logout();
        return redirect()->route('login')->with('success','Logout Success');
    }

  
    
}

