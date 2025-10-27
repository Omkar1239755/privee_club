<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};

class DashboardController extends Controller
{

public function index()
{
    $user = User::count();
    // $volunteer = User::where('user_type','2')->count();
    return view('admin::dashboard',compact('user'));
}


  public function user(){
      
     $user = User::orderBy('id', 'desc')->get();
     return view('admin::user.index',compact('user'));
  }
  
  public function viewUser($id){
      
   $user = User::where('id',$id)->first();   
   return view( 'admin::user.show',compact('user'));
      
  }
  
  

public function Catgeory(){
     $title= "Catgeory";
    return view('admin::catgeory.index',compact('title'));
   } 

public function add(){
   return view('admin::catgeory.add');
 } 

   

}
