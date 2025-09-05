<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use  App\Models\{User};

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
                return response()->json(['status'=>true,'message'=>'registration succesfully','data'=>$user],200);
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

                if(Auth::attempt(['email' => $email, 'password' => $password])){






                    
                    }
                else{
                   return  response()->jscon([
                     'status'=>false,
                     'messsage'=>'Invallid credentials',

                   ]);
                }





    }




}
