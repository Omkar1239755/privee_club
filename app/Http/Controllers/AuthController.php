<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Auth;
use  App\Models\{User,DeviceInfo};

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
                    'password'=>'required'
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
                return response()->json(['status'=>true,'status_code' => 200,'message'=>'registration succesfully','data'=>$user],200);
        }
      } catch (\Throwable $e) {
         return response()->json(['status'=>false,'message'=>$e->getMessage()],422);
      }


    }
// ****************************************************Login*************************************************************************************
    public function Login(request $request){

         $rules = [
         'email'=>'required',
         'password'=>'required'
        ];
        $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
            }
                if(Auth::attempt(['email' => $request->email, 'password' =>  $request->password])){
                  $user = Auth::user();
                  $token  = $user->createToken('prive')->plainTextToken;
                  $user['token'] =$token;
               
                  //genrate fcm token 
                  $fcmToken = new DeviceInfo;
                  $fcmToken->user_id   = $user->id;
                  $fcmToken->fcm_token = $token;
                  $fcmToken->device_id = $request->device_id;
                  $fcmToken->device_type = $request->device_type;
                  $fcmToken->save();
                  
                  return response()->json(['status' => true, 'status_code' => 200, 'message' => 'Login Successfull!', 'data' => $user], 200);
                    }
                else{
                   return  response()->json([
                     'status_code'=>401,
                     'status'=>false,
                     'messsage'=>'Invallid credentials',

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
                   return response()->json(['status' => true, 'message' => 'logout successfully']);
              }else{
                  $error_message = 'failed to logout';
                  return response()->json(['status' => false, 'message' => $error_message]);
              }            
       }catch(\Exception $e){
              return response()->json(['status' => false, 'message' => $e->getMessage()]);
          }
      }

}
