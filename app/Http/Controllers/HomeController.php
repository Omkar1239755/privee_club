<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\{User,LookngFor};
use Carbon\Carbon;

class HomeController extends Controller
{

// ************************************home api*************************************************************************************8
public function home(){
        try{

            $user = User::select('first_name','profile_image','region','dob')->get();
            return response()->json(['status'=>true,'status_code' => 200,'message'=>'Data Retrieve succesfully','data'=>$user],200);
                
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()],422);
        }

 }
// ********************************view detail *****************************************************************************************

public function viewDetail(request $request){
    try{

    $userid = $request->id;

    $user = User::where('id',$userid)->first(); 
    $age = Carbon::parse($user->dob)->age;

    $looking_forids = $user->looking_for;
    $lookin_for = explode(',',$looking_forids);
   
   $lookingforname = LookngFor::whereIn('id', $lookin_for)
                     ->pluck('looking_for');

//  fetching multiple image 
//   $images =    User::with('images')->where('id', $userid)->get('profile_image');

//   return $images;


    $data   =[
        "id"          => $user->id,
        "first_name"  => $user->first_name,
        "last_name"   => $user->last_name,
        "city"        =>$user->city,
        "age"=>$age,
        "looking_for"=> $lookingforname,
        "about"=>[
                    "about_me" => $user->about_me,
                    "about_match" => $user->about_match,
           ],
        "info"=>[
                "age"=>$age,
                "height"=>$user->height,
                "weight"=>$user->weight,
                "hair_color"=>$user->hair_color,
                "eye_color"=>$user->eye_color,
                "body_type"=>$user->body_type,
                "nationality"=>$user->nationality,
                "city"=>$user->city,
                "sexual_orientation"=>$user->sexual_orientation,
                "education"=>$user->sexual_orientation,
                "field_of_work"=>$user->field_of_work,
                "relationship_status"=>$user->relationship_status,
                "zodiac_sign"=>$request->zodiac_sign,
             ] ,

        "personal_information" =>[
            "smoking"=>$user->smoking,
            "drinking"=>$user->drinking,
            "tattoos"=>$user->tattoos,
            "piercings"=>$user->piercings,
            "relationship_status"=>$user->relationship_status
          ]  

    ];
return $data;
   
    

    return response()->json(['status'=>true,'status_code' => 200,'message'=>'User Data Retrieve succesfully','data'=>$data],200);
           
    }catch(\Exception $e){
      return response()->json(['status'=>false,'message'=>$e->getMessage()],422);    
    }

}





}
