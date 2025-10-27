<?php

namespace Modules\Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;
use Hash;
use App\Models\User;

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
    
     
    public function updateStatus(Request $request)
    {
        try {
            $user = User::find($request->user_id);
    
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found!'
                ], 404);
            }
    
            $user->admin_status = $request->admin_status;
    
            
            if ($request->admin_status == 1) {
                $user->admin_approve_time = now();
            } else {
                $user->admin_approve_time = null; 
            }
    
            $user->save();
    
            return response()->json([
                'status'  => true,
                'message' => 'Admin status updated successfully!',
                'data'    => [
                    'user_id'            => $user->id,
                    'admin_status'       => $user->admin_status,
                    'admin_approve_time' => $user->admin_approve_time,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }



public function destroy($id)
{
  
    $user = User::find($id);
    if ($user) {
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully!'
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => 'User not found!'
    ]);
}


  public function updateProfileApproval(Request $request)
{
    try {
        $user = User::findOrFail($request->user_id);
        $user->profile_approval = $request->profile_approval;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile approval updated successfully!',
            'profile_approval' => $user->profile_approval
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

      
            

    
public function logout(){
    Auth::logout();
    return redirect()->route('admin.login');
 }
       
    
    
    
    

}
