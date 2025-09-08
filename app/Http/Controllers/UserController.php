<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use  App\Models\{User,HearAboutUs};
class UserController extends Controller
{
    
// ***********************************************verification image for user ************************************************************************************
public function verificationImage(request $request){
    try{

        $rule =[
        'verify_image'=>'required'  
        ];

        $validator = Validator::make($request->all(),$rule);
            if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
            }
        
        $user = Auth::user();

            if($request->has('verify_image')){
            $image = $request->verify_image;
            $name  = time().'.'.$image->getClientOriginalExtension();
            $path = public_path('uploads/users/');
            $image->move($path,$name);
            $user->verification_image = 'public/uploads/users/'.$name;
            $user->save();     
            };
        return response()->json(['status' => true, 'status_code' => 200, 'message' => "verification image uploded succesfully", 'data' => $user], 200);

        }catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => $e->getMessage()], 422);
            }
    }

// ***********************************************************profile image *************************************************************************

public function profileImage(){

  try{

        $rule =[
        'profile_image'=>'required'
        ];
  
       $validator = Validator::make($request->all(),$rule);
        if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
            }

        $user = Auth::user();

        if($request->has('profile_image')){
        $image = $request->profile_image;
        $name  = time().'.'.$image->getClientOriginalExtension();
        $path = public_path('uploads/profile_image/');
        $image->move($path,$name);
        $user->verification_image = 'public/uploads/profile_image/'.$name;
        $user->save();     
        };
       return response()->json(['status' => true, 'status_code' => 200, 'message' => "Profile image uploded succesfully", 'data' => $user], 200);


    }catch(\Exception $e){
    return response()->json(['status' => false, 'message' => $e->getMessage()], 422);
    }

}


// ******************************************************additional detail ****************************************************************************

public function additionalDetail(request $request){

try{

         $rules = [
                    "dob"=>"required",
                    "height"=>"required",
                    "weight"=>"required",
                    "body_type"=>"required",
                    "hair_color"=>"required",
                    "eye_color"=>"required",
                    "nationality"=>"required",
                    "region"=>"required",
                    "city"=>"required",
                    "sexual_orientation"=>"required",
                    "education"=>"required",
                    "field_of_work"=>"required",
                    "relationship_status"=>"required",
                    "zodiac_sign"=>"required",
                    "smoking"=>"required",
                    "drinking"=>"required",
                    "tattoos"=>"required",
                    "piercings"=>"required",
                    "about_me"=>"required",
                    "about_match"=>"required"
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
            }

         $user=Auth::user();
            if (!$user) {
                return response()->json([
                    "status" => false,
                    "message" => "Unauthorized"
                ], 401);
            }

        if($request->first_name){
            $user->first_name = $request->first_name ?? $user->name;
        }

        if($request->last_name){
            $user->last_name = $request->last_name ?? $user->last_name;
        }

       if($request->profile_name){
            $user->profile_name = $request->profile_name ?? $user->profile_name;
        }

        if($request->email){
            $user->email = $request->email ?? $user->email;

        }

        if($request->country_code){
            $user->country_code = $request->country_code ?? $user->country_code;

        }


        if($request->mobile_no){
            $user->mobile_no = $request->mobile_no ?? $user->mobile_no;

        }

        if($request->password){
            $user->password = $request->password ?? $user->password;

        }
        $user->dob = $request->dob;
        $user->height = $request->height;
        $user->weight = $request->weight;
        $user->body_type = $request->body_type;
        $user->hair_color = $request->hair_color;
        $user->eye_color = $request->eye_color;
        $user->nationality = $request->nationality;
        $user->region = $request->region;
        $user->city = $request->city;
        $user->sexual_orientation = $request->sexual_orientation;
        $user->education = $request->education;
        $user->field_of_work = $request->field_of_work;
        $user->relationship_status = $request->relationship_status;
        $user->zodiac_sign = $request->zodiac_sign;
        $user->smoking = $request->smoking;
        $user->drinking = $request->drinking;
        $user->tattoos = $request->tattoos;
        $user->piercings = $request->piercings;
        $user->about_me = $request->about_me;
        $user->about_match = $request->about_match;

        $user->save();
        $user->refresh();

     return response()->json([
                "status_code"=>200,
                "status" => true,
                "message" => "Details inserted successfully",
                "data" => $user
            ], 200); 
        }catch(\Exception $e){
        return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
    }

}

// *********************************************************api to  get hear abt us ********************************************************************


public function hearAboutUsListing(){
    $data = HearAboutUs::get();
    return response()->json([
            "status_code"=>200,
            "status" => true,
            "message" => " HearAboutUs detail retrive successfully",
            "data" => $data
        ], 200); 
}

// *****************************************************store hear abt us *************************************************************************

public function hearAboutUS(request $request){
  try{
        $rule = [
        "id"=>"required"
        ];

         $validator = Validator::make($request->all(),$rule);

        if ($validator->fails()) {
        return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }


        $user = Auth::user();
        $user->hear_about_us = $request->id ;
        $user->save();
        return response()->json([
        "status_code"=>200,
        "status" => true,
        "message" => " Data retrive successfully",
        "data" => $user
        ], 200);

    }catch(\Exception $e){
        return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
    }

}






























}



