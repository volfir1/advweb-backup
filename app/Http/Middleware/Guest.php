<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:3|max:12|confirmed',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'contact' => 'required|string|digits:11',
            'address' => 'required|string|max:255'
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $customer = Customer::create([
                'user_id' => $user->id,
                'fname' => $validated['fname'],
                'lname' => $validated['lname'],
                'contact' => $validated['contact'],
                'address' => $validated['address']
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'You have successfully registered']);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Something went wrong, please try again', 'error' => $e->getMessage()], 500);
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->is_admin) {
                return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
            } else {
                return response()->json(['success' => true, 'redirect' => route('customer.dashboard')]);
            }
        }

        return response()->json(['success' => false, 'message' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout Success');
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->exists();
        return response()->json(['exists' => $exists]);
    }
}
