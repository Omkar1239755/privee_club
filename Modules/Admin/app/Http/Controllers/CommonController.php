<?php
namespace Modules\Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\{PrivacyPolicy,Term};
class CommonController extends Controller
{ 
    
   public function privacy(Request $request)
   {
        if ($request->isMethod('post')) {
            $request->validate([
              'privacy'=>'required' 
               
            ]);
        PrivacyPolicy::create([
            'privacy_policy' =>$request->privacy
        ]);
       
       }
       $privacy = PrivacyPolicy::first();
       return view('admin::privacy',compact('privacy'));
    }
    
    
    
    public function term(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
              'term'=>'required' 
               
            ]);
        Term::create([
            'term' =>$request->term
        ]);
       
       }
       $term = Term::first();
       return view('admin::term',compact('term'));
    }
    
  
}
