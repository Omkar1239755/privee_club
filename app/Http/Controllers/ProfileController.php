<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{UserIntrest,UserImage,User,LookngFor,City,Region,Nationality,SexOrientation,Zodiac,BodyType,UserRate};
use Auth;
use Validator;
use Carbon\Carbon;

class ProfileController extends Controller
{
    
//************************************************************edit account ******************************************************************
public function editAccount(Request $request)
{
    try {
       
        $request->validate([
            'profile_name' => 'nullable',
            'first_name'  => 'nullable',
            'last_name'   => 'nullable',
            'mobile_no'   => 'nullable',
            'email'       => 'nullable',
            'dob'         => 'nullable',
            'gender'      => 'nullable'
        ]);

        $user = Auth::user();
        
        if($request->profile_name){
        $user->profile_name = $request->profile_name ??$user->profile_name;
        }
        if($request->first_name){
        $user->first_name = $request->first_name ??$user->first_name;
        }
        if($request->last_name){
        $user->last_name = $request->last_name ??$user->last_name;
        }
        if($request->mobile_no){
        $user->mobile_no = $request->mobile_no ??$user->mobile_no;
        }
        if($request->email){
        $user->email = $request->email ??$user->email;
        }
        if($request->dob){
        $user->dob = $request->dob ??$user->dob;
        }
        if($request->gender){
        $user->gender = $request->gender ??$user->gender;
        }
  
        $user->save(); 

        return response()->json([
            'status'      => true,
            'status_code' => 200,
            'message'     => "Account detail updated sucessfully",
            'data'        => $user
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ], 422);
    }
}

// ********************************************************************edit about**************************************************************************
  public function editAbout(Request $request)
{
    try {
       
        $request->validate([
            'about_me' => 'nullable'
        ]);

        $user = Auth::user();
        
        if($request->about_me){
        $user->about_me = $request->about_me ??$user->about_me;
        }
       
        $user->save(); 

        return response()->json([
            'status'      => true,
            'status_code' => 200,
            'message'     => "User about me detail updated sucessfully",
            'data'        => $user
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ], 422);
    }
}  
    
 
// ***********************************************************************editperfectMatch**********************************************************  
  public function editAboutMatch(Request $request)
 {
    try {
       
        $request->validate([
            'about_match' => 'nullable'
        ]);

        $user = Auth::user();
        
        if($request->about_match){
          $user->about_match = $request->about_match ??$user->about_match;
        }
       
        $user->save(); 

        return response()->json([
            'status'      => true,
            'status_code' => 200,
            'message'     => "User about match detail updated sucessfully",
            'data'        => $user
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ], 422);
    }
}  
 
//  *********************************************************************edit personall info********************************************************
  public function editPersonallInfo(request $request){

try{

         $rules = [
                 
                    "height"=>"nullable",
                    "weight"=>"nullable",
                    "body_type"=>"nullable",
                    "hair_color"=>"nullable",
                    "eye_color"=>"nullable",
                    "nationality"=>"nullable",
                    "region"=>"nullable",
                    "city"=>"nullable",
                    "sexual_orientation"=>"nullable",
                    "education"=>"nullable",
                    "field_of_work"=>"nullable",
                    "relationship_status"=>"nullable",
                    "zodiac_sign"=>"nullable",
                    "smoking"=>"nullable",
                    "drinking"=>"nullable",
                    "tattoos"=>"nullable",
                    "piercings"=>"nullable",
                    
    
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
        
        if($request->height){
            
         $user->height = $request->height ??$user->height ;   
            
        }
        
        if($request->weight){
            
         $user->weight = $request->weight ??$user->weight ;   
            
        }
        
        if($request->body_type){
            
         $user->body_type = $request->body_type ??$user->body_type ;   
            
        }
        
       if($request->hair_color){
            
         $user->hair_color = $request->hair_color ??$user->hair_color ;   
            
        }
        
        if($request->eye_color){
            
         $user->eye_color = $request->eye_color ??$user->eye_color ;   
            
        }
        
       if($request->nationality){
            
         $user->nationality = $request->nationality ??$user->nationality ;   
            
        }
        
        if($request->region){
            
         $user->region = $request->region ??$user->region ;   
            
        }
        
       if($request->city){
            
         $user->city = $request->city ??$user->city ;   
            
        }
        
      if($request->sexual_orientation){
            
         $user->sexual_orientation = $request->sexual_orientation ??$user->sexual_orientation ;   
            
        }
        
       if($request->education){
            
         $user->education = $request->education ??$user->education ;   
            
        }
        
       if($request->field_of_work){
            
         $user->field_of_work = $request->field_of_work ??$user->field_of_work ;   
            
        }
        
        if($request->relationship_status){
            
         $user->relationship_status = $request->relationship_status ??$user->relationship_status ;   
            
        }
        
        if($request->zodiac_sign){
            
         $user->zodiac_sign = $request->zodiac_sign ??$user->zodiac_sign ;   
            
        }
        
        if($request->smoking){
            
         $user->smoking = $request->smoking ??$user->smoking ;   
            
        }
        
       if($request->drinking){
            
         $user->drinking = $request->drinking ??$user->drinking ;   
            
        }
        
       if($request->tattoos){
            
         $user->tattoos = $request->tattoos ??$user->tattoos ;   
            
        }
        
       if($request->piercings){
            
         $user->piercings = $request->piercings ??$user->piercings ;   
            
        }
 
        $user->save();
      
    //   user intreset
        $UserIntrestData = UserIntrest::where('user_id',$user->id)->first();
    
            if($request->fav_music){
               $UserIntrestData->fav_music = $request->fav_music ??  $UserIntrestData->fav_music ;    
              }
              
           if($request->fav_tv_show){
               $UserIntrestData->fav_tv_show = $request->fav_tv_show ??  $UserIntrestData->fav_tv_show ;    
              }
              
            if($request->fav_movie){
               $UserIntrestData->fav_movie = $request->fav_movie ??  $UserIntrestData->fav_movie ;    
              }
              
              
           if($request->fav_book){
               $UserIntrestData->fav_book = $request->fav_book ??  $UserIntrestData->fav_book ;    
              }
              
                      
           if($request->fav_sport){
               $UserIntrestData->fav_sport = $request->fav_sport ??  $UserIntrestData->fav_sport ;    
              }
              
           $UserIntrestData->save();
              
   
     return response()->json([
                "status_code"=>200,
                "status" => true,
                "message" => "Data updated successfully",
              
            ], 200); 
        }catch(\Exception $e){
        return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
    }

} 
   
   
//   ******************************************************edit lookingfor ********************************************************************************************
public function editLookingFor(Request $request)
{
    try {
        
        $request->validate([
            'looking_for_ids' => 'nullable|array',
        ]);

        $user = Auth::user(); 

        if ($request->filled('looking_for_ids')) {
            $ids = $request->looking_for_ids ;
            $user->looking_for = implode(',', $ids); // 34
            $user->save(); 
       }else{
          return response()->json([
                "status_code" => 200,
                "status"      => true,
                "message"     => "No change made",
            ], 200);
     }
        
        return response()->json([
            "status_code" => 200,
            "status"      => true,
            "message"     => "Data saved successfully",
            "data"        => $user
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            "status"  => false,
            "message" => $e->getMessage()
        ], 500);
    }
}

// *****************************************************************************edit user image ***************************************************************************
public function deleteUserImage(Request $request)
{
    try {
      $request->validate([
                "image_id"   => "required_without:delete_all|exists:user_images,id",
                "delete_all" => "nullable|boolean",
            ]);


        $user = Auth::user(); 

        if ($request->delete_all) {
           
                $images = UserImage::where('user_id', $user->id)->get();
    
                if ($images->isEmpty()) {
                    return response()->json([
                        "status"  => false,
                        "message" => "No images found for this user",
                    ], 404);
                }
    
                foreach ($images as $image) {
                    $image->delete();
                }
    
                return response()->json([
                    "status"      => true,
                    "status_code" => 200,
                    "message"     => "All user images deleted successfully",
                ], 200);

           } elseif ($request->filled('image_id')) {

            $image = UserImage::where('id', $request->image_id)
                              ->where('user_id', $user->id)
                              ->first();

            if (!$image) {
                return response()->json([
                    "status"  => false,
                    "message" => "Image not found or does not belong to you",
                ], 404);
            }

    
            $image->delete();   
            return response()->json([
                "status"      => true,
                "status_code" => 200,
                "message"     => "User image deleted successfully",
            ], 200);
        }

    } catch (\Exception $e) {
        return response()->json([
            "status"  => false,
            "message" => $e->getMessage()
        ], 500);
    }
}


// *******************************************************************store privatephoto *************************************************************************
public function privatePhoto(Request $request)
{
    $request->validate([
        "private_photo" => "required",
    ]);

    $user = Auth::user();
    $savedImages = []; 

    if ($request->hasFile('private_photo')) {

        $images = $request->file('private_photo');

        if (!is_array($images)) {
            $images = [$images];
        }

        foreach ($images as $image) {
            $name = time() . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/private_image/');
            $image->move($path, $name);

            $savedImages[] = UserImage::create([
                'user_id' => $user->id,
                'profile_image' => 'public/uploads/private_image/' . $name,
                'type' => 1,
            ]);
        }
    }

    return response()->json([
        "status" => true,
        "code" => 200,
        "message" => "Private photos uploaded successfully",
        "data" => $savedImages,
    ]);
}




//  ******************************************************************************admin status *********************************************************************************************
 public function adminStatus(request $request){
             
        $user = Auth::user();
    
        $adminstatus = $user->admin_status;

        
        if($adminstatus == 1){
            
             return response()->json([
                    "status"      => true,
                    "status_code" => 200,
                    "message"     => "Your admin status is approved",
                    "adminstatus" =>$adminstatus
                ], 200);
        }
        
              return response()->json([
                        "status"      => false,
                        "status_code" => 404,
                        "message"     => "admin status is not approved",
                    ], 200);
                
                 
            
    }
    
//******************************************************************************profile detail of user ***************************************************************************************************
public function profileDetail(){
    try{

    $userid = Auth::id();

    $user = User::where('id',$userid)->first(); 
    
    $age = Carbon::parse($user->dob)->age;

    $looking_forids = $user->looking_for;
    // string to array via explode fn
    $lookin_for = explode(',',$looking_forids);
   

    $lookingforname = LookngFor::whereIn('id', $lookin_for)
                     ->pluck('looking_for');

    // fetching multiple image 
    $publicimages = UserImage::select('id', 'user_id', 'profile_image as gallery_image')
        ->where('user_id', $userid)
        ->where('type', 2)
        ->get();

                
    $privateImage = UserImage::select('id', 'user_id', 'profile_image as gallery_image')
        ->where('user_id', $userid)
        ->where('type', 1)
        ->get();
        
   $userIntrest = UserIntrest::where('user_id',$userid)->first();
    
    $body_type = BodyType::where('body_type',$user->body_type)->first();
    $cityData = City::where('city',$user->city)->first();
    $regionData = Region::where('region',$user->region)->first();
    $nationality = Nationality::where('nationality',$user->nationality)->first();
    $sexuallorientation = SexOrientation::where('sex_orientation',$user->sexual_orientation)->first(); 
    $zodiacSign = Zodiac::where('Zodiac_Signs',$user->zodiac_sign)->first(); 
     
    $data   =[
        "id"          => $user->id,
        "first_name"  => $user->first_name,
        "last_name"   => $user->last_name,
        "profile_name"   => $user->profile_name,
        "city"        =>$cityData,
        "email"=>$user->email,
        "gender"=>$user->gender,
        "mobile_no"=>$user->mobile_no,
        "dob"=>$user->dob,
        "age"=>$age,
        "looking_for"=> $lookingforname,
        "profile_image"=> $user->profile_image ,
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
                "body_type"=>$body_type,
                "nationality"=>$nationality,
                "region"=>$regionData,
                "city"=>$cityData,
                "sexual_orientation"=>$sexuallorientation,
                "education"=>$user->sexual_orientation,
                "field_of_work"=>$user->field_of_work,
                "relationship_status"=>$user->relationship_status,
                "zodiac_sign"=>$zodiacSign,
             ] ,

        "personal_information" =>[
            "smoking"=>$user->smoking,
            "drinking"=>$user->drinking,
            "tattoos"=>$user->tattoos,
            "piercings"=>$user->piercings,
            "relationship_status"=>$user->relationship_status
          ] ,
        "public_images" => $publicimages,
 
       "private_images" =>$privateImage,
  
        "user_intrest"  => $userIntrest
            
        
    ];
    return response()->json(['status'=>true,'status_code' => 200,'message'=>'User Data Retrieve succesfully','data'=>$data],200);
           
    }catch(\Exception $e){
      return response()->json(['status'=>false,'message'=>$e->getMessage()],422);    
    }

}

// *************************************************************************PROFILE TIMER *****************************************************************************************
public function profileTimer()
{
    $user = Auth::user();

    $age = Carbon::parse($user->dob)->age;

    $data = [
        'id' => $user->id,
        'name' => $user->first_name,
        'last_name' => $user->last_name,
        'age' => $age,
        'profile_image'=>$user->profile_image,
        'email'=>$user->email
    ];

    $now = now();
    
    // ratings
    $yesRatingAvg = UserRate::where('reciever_id', $user->id)->where('reaction', 'YES')->avg('points') ?? 0;
    $okRatingAvg = UserRate::where('reciever_id', $user->id)->where('reaction', 'OK')->avg('points') ?? 0;
    $maybeRatingAvg = UserRate::where('reciever_id', $user->id)->where('reaction', 'Maybe')->avg('points') ?? 0;
    $noRatingAvg = UserRate::where('reciever_id', $user->id)->where('reaction', 'No')->avg('points') ?? 0;

    $allRatings = UserRate::where('reciever_id', $user->id)->get();
    $totalRaters = $allRatings->count();
    $overallAvgPoints = $totalRaters > 0 ? $allRatings->avg('points') : 0;
    
       // managing RATING status  for in and out
        if ($user->profile_approval == 1) {
            $user->profie_rating_status = 'IN';
            $user->save();
        }
        else {
            $expireTime = Carbon::parse($user->admin_approve_time)->addHours(24);
            $averageRating = $user->receivedRatings->avg('points') ?? 0;
            $totalRatings = $user->receivedRatings->count();
                //current time agar expiry se jada tab he rate krskta hai 
                if (now() >= $expireTime) {
                //   tab he chec kro 
                     if($averageRating > 0 && $totalRatings >=4){
                 
                       $user->profie_rating_status  = 'IN';
                       $user->save();
                         
                     }
                }
        }

    $expiryTime = Carbon::parse($user->admin_approve_time)->addHours(24);
    // agar timer kahatam hua toh
    if ($now->greaterThanOrEqualTo($expiryTime)) {
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Profile rating period expired',
            'data' => $data,
            'time_left' => '00:00:00',
            'overall_rating'=>$overallAvgPoints,
            'expires_at' => $expiryTime->toDateTimeString(),
           'profile_rating_status'=> $user->profie_rating_status,
        ]);
    }
    
    $timeLeft = $now->diffInSeconds($expiryTime);
    $hours = floor($timeLeft / 3600);
    $minutes = floor(($timeLeft % 3600) / 60);
    $seconds = $timeLeft % 60;

    return response()->json([
        'status' => true,
        'code' => 200,
        'data' => $data,
        'message' => 'Profile is still active',
        'time_left' => sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds),
        'expires_at' => $expiryTime->toDateTimeString(),
        'profile_rating_status'=> $user->profie_rating_status,
        
        'ratings' => [
            'hot' => round($yesRatingAvg, 2),
            'ok_avg' => round($okRatingAvg, 2),
            'maybe_avg' => round($maybeRatingAvg, 2),
            'no_avg' => round($noRatingAvg, 2),
            'overall_avg'=>$overallAvgPoints,
            
        ]
    ]);
}


// ************************************************************************edit profile ***************************************************************************************************
public function editProfileImage(request $request){
    
   $request->validate([
      'profile_image'=>'required'   
   ]);
        
  $user = Auth::user();

    // delete old image
     if ($user->profile_image && file_exists(public_path(str_replace('public/', '', $user->profile_image)))) {
            unlink(public_path(str_replace('public/', '', $user->profile_image)));
        }

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name  = time().'.'.$image->getClientOriginalExtension();
            $path  = public_path('uploads/users/');
            $image->move($path, $name);

            $user->profile_image = 'public/uploads/users/'.$name;
            $user->save();
        }
    
      return response()->json([
            'status'      => true,
            'status_code' => 200,
            'message'     => "Profile image updated successfully",
            'data'        => $user->profile_image
        ], 200);

    
}

// *****************************************************************************online offline status *********************************************************************
public function onlineStatus(Request $request)
{            
            $request->validate([
                'online_status' => 'required', 
            ]);
            
            // online,offline
            $user = Auth::user(); 
            $user->online_status = $request->online_status;
            $user->save();
        
            return response()->json([
                'status'      => true,
                'status_code' => 200,
                'message'     => "Status updated successfully",
            ], 200);
        }

}
