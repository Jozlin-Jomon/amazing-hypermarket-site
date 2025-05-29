<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /*
    View Login Form - Admin
    Created On: 06-05-2025
    */
    public function admin_login(){
        return view('auth.admin-login');
    }


    /*
    Post Login functionality - Admin
    Created On: 06-05-2025
    */
    public function post_login_admin(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Check if the authenticated user is an admin
            if (Auth::user()->usertype === 'admin') {
                $request->session()->regenerate();

                if ($request->ajax()) {
                    return response()->json([
                        'success'   => true,
                        'redirect'  => route('admin.dashboard')
                    ]);
                }

                return redirect()->intended('admin.dashboard');
            }

            // If not an admin, log out and return error
            Auth::logout();
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Admins only.'
                ], 403);
            }

            return back()->withErrors([
                'email' => 'Access denied. Admins only.'
            ])->onlyInput('email');
        }

        // If credentials are invalid
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.'
            ], 401);
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }



    /*
    View Login Form
    Created On: 02-05-2025
    */
    public function login(){
        return view('auth.login');
    }


    /*
    Post Login functionality
    Created On: 02-05-2025
    */
    public function post_login(Request $request){
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:8',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->usertype === 'user') {
                $request->session()->regenerate();
                if ($request->ajax()) {
                    return response()->json([
                        'success'   => true,
                        'redirect'  => route('index')
                    ]);
                }
                return redirect()->intended('index');
            }
            
            Auth::logout();
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. User only.'
                ], 403);
            }

            return back()->withErrors([
                'email' => 'Access denied. User only.'
            ])->onlyInput('email');
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.'
            ], 401);
        }
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }


    /*
    Logout
    Created On: 02-05-2025
    */
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    /*
    View Sign Up Form
    Created On: 06-05-2025
    */
    public function signup(){
        return view('auth.register');
    }

    /*
    Post Sign Up Functionality
    Created On: 06-05-2025
    */
    public function post_signup(Request $request){
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|digits:10',
            'password'      => 'required|min:8|confirmed',
            'terms'         => 'accepted',
        ]);
        $user = User::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'password'      => Hash::make($request->password),
            'usertype'      => 'user',
            'status'        => '0',
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Account created successfully. Please log in.',
            'redirect' => route('login'),
        ]);  
    }   
}