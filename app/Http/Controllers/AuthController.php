<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Auth;
use  App\Models\{User,DeviceInfo,PrivacyPolicy,TermsCondition};
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function registerUSer(request $request){
      try {
                 
        $header = $request->header('X-CLIENT');
        if(empty($header)){
            $msg = 'Authorization Token is Required!';
            return response()->json([
                        'status' => false,
                        'message' =>  $msg,
                    ], 422);
        }
        else{
                $rules= [
                    'first_name'=>'required',
                    'last_name'=>'required',
                    'profile_name'=>'required',
                    'email'=>'required|email|unique:users',
                    'country_code'=>'required',
                    'mobile_no'=>'required',
                    'fcm_token'=>'required',
                    'device_id'=>'required',
                    'device_type'=>'required',
                    'password'=>'required|confirmed'
                ]; 

                $validator = Validator::make($request->all(),$rules);
                if ($validator->fails()) {
                        return response()->json([
                        'status' => false,
                        'message' => $validator->errors()->first(),
                    ], 422);
                }   

                $user = new User;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->profile_name = $request->profile_name;
                $user->email = $request->email;
                $user->country_code = $request->country_code;
                $user->mobile_no = $request->mobile_no;
                $user->password  = Hash::make($request->password);
                $user->save();
                $user->refresh();
                
                
              // confirmation email
              Mail::send('email_registration', ['user' => $user], function($message) use ($user) {
                    $message->to($user->email, $user->first_name)
                            ->subject('Registration Successful');
                });


                $token  = $user->createToken('prive')->plainTextToken;
                $user['token'] =$token;
                
                      //genrate fcm token 
                  $fcmToken = new DeviceInfo;
                  $fcmToken->user_id   = $user->id;
                  $fcmToken->fcm_token = $token;
                  $fcmToken->device_id = $request->device_id;
                  $fcmToken->device_type = $request->device_type;
                  $fcmToken->save();
                  
                  
               
                return response()->json(['status'=>true,'status_code' => 200,'message'=>'User Registration Done succesfully','data'=>$user],200);
        }
      } catch (\Throwable $e) {
         return response()->json(['status'=>false,'message'=>$e->getMessage()],422);
      }


    }
// ****************************************************Login*************************************************************************************
    public function Login(request $request){
        
         $rules = [
         'email'       => 'required',
        'password'    => 'required',
        'device_id'   => 'required',
        'device_type' => 'required',
        'fcm_token'   => 'nullable'
        ];
        $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
            }
                if(Auth::attempt(['email' => $request->email, 'password' =>  $request->password])){
                  $user = Auth::user();
                  $token  = $user->createToken('prive')->plainTextToken;
                  $user['token'] =$token;
               
      
                  
                $fcmToken = DeviceInfo::firstOrCreate(
                ['user_id' => $user->id, 'device_id' => $request->device_id],
                [
                    'device_id' => $request->device_id,
                    'device_type' => $request->device_type,
                    'fcm_token' => $request->fcm_token,
                ]
            );
            
                if(is_null($user->first_name) || is_null($user->profile_image) ||
                    is_null($user->gender) || is_null($user->looking_for) ||
                    is_null($user->weight) || is_null($user->hear_about_us)){
                    
                    $registration_status = false; 
                    $user['registration_status'] = $registration_status;
                    return response()->json(['status' => true, 'status_code' => 200, 'message' => 'User Login Successfull!', 'data' => $user], 200);
                    
                }

                $registration_status = true;
                $user['registration_status'] = $registration_status;
            
                return response()->json(['status' => true,'status_code' => 200, 'message' => 'User Login Successfull!', 'data' => $user], 200);
                    }
                else{
                   return  response()->json([
                     'status_code'=>401,
                     'status'=>false,
                     'messsage'=>'Wrong email or password',
    
                   ]);
            }

    }

// ***************************************************************logout ********************************************************************************

public function logout(request $request){

       try{
              $validated = $request->validate([
                  'device_id' => 'required',
              ]);
              
              if(auth()->user()){
                    $device = DeviceInfo::where('user_id', auth()->user()->id)->where('device_id', $request->device_id)->delete();
                    auth()->user()->tokens()->delete();
                   return response()->json(['status' => true,'code'=>200,'message' => 'Logout successfully']);
              }else{
                  $error_message = 'failed to logout';
                  return response()->json(['status' => false, 'message' => $error_message]);
              }            
       }catch(\Exception $e){
              return response()->json(['status' => false, 'message' => $e->getMessage()]);
          }
      }
      
//*****************************************************************sendotp *********************************************************************************


public function sendOtp(request $request){
    
   $request->validate([
    'email'=>'required|email'    
        ]);
    
    $user = User::where('email',$request->email)->first();
     if (!$user) {
            return response()->json(['status' => false, 'message' => 'Email not found, Please  enter vallid email'], 404);
        }
    $otp =rand(100000,999999); 
    $user->otp = $otp;
    $user->save();
    
      Mail::send('email',['otp'=>$otp,'user'=>$user], function($message) use ($user) {
            $message->to($user->email)
                    ->subject("Password Reset OTP");
        });
        
       return response()->json(['status' => true,'code'=>200, 'message' => 'OTP sent to your Registered Email']);
   
}

// *****************************************************************verifyy otp ***************************************************************************************

public function verifyOtp(request $request){
   

 $request->validate([
    'otp'=>'required',
    'email'=>'required|email'
  ]);
    
    $user = User::where('email',$request->email)->first();
    
    $otp = $user->otp;

  
    if( $user->otp != $request->otp){
    return response()->json(['status' => false,'code'=>400,  'message' => 'Invalid OTP'], 400);
    }

   return response()->json(['status' => true,'code'=>200, 'message' => 'OTP verified','otp' =>$otp]);
    
}

//****************************************************************************change password ************************************************************************

 public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || $user->otp != $request->otp) {
            return response()->json(['status' => false, 'code'=>400,'message' => 'Invalid request'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->save();

       return response()->json(['status' => true,'code'=>200, 'message' => ' Your Password reset successfully']);
        
  }

// ***************************************************************privacy pliciy******************************************************************************************************
 public function getPrivicy(Request $request)
  {
        $data =PrivacyPolicy::all(); 

       return response()->json(['status' => true,'code'=>200, 'message' => ' Data retrieve sucessfully','data'=>$data]);
        
  }

// ***********************************************************************term and condition *************************************************************************************************
 public function terms(Request $request)
  {
        $data =TermsCondition::all(); 

       return response()->json(['status' => true,'code'=>200, 'message' => ' Data retrieve sucessfully','data'=>$data]);
        
  }


}
