<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  
    public function index()
    {
        // $user = User:count();
        // $volunteer = User::where('user_type','2')->count();
        return view('admin::dashboard');
    }

}
