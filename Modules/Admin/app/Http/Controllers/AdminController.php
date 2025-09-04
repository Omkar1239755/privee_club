<?php

namespace Modules\Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;
use Hash;

class AdminController extends Controller
{ 
public function adminLogin(Request $request) {

   if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $credentials = $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
            

            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect('admin/dashboard');
            } else {             
                return back()->with('error_message', 'Invalid Credentials!');
            }
        }

        return view('admin::login');
    }

}
