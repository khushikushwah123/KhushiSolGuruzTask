<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{Admin,Product,User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->submit) {
            $request->validate(['email' => 'required|email|exists:admins,email', 'password' => 'required']);

            $admin = Admin::where('email', $request->email)->first();
            if (Hash::check($request->password, $admin->password)) {
                Auth::guard('admin')->login($admin);

                return redirect('admin/dashboard');
            } else {
                return back()->with('danger', 'Incorrect password.');
            }

            return back()->with('failed', 'Please check your email or password.')->withInput();
        }

        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dashboard()
    {
        $page_title = 'Welcome to Dashboard';
        $products = Product::count();
        $buyers = User::where('role','Buyer')->count();
        $seller = User::where('role','Seller')->count();
        return view('admin::dashboard', compact('page_title','products','seller','buyers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect('administrator');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
