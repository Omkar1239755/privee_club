<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\{User,LookngFor,UserRate,UserStatus,UserImage,ViewProfile,RequestModel};
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{

public function home()
{
    try {
        $user  = Auth::user();
        $userImage = $user->profile_image;
       // Get opposite gender
       $oppositeGender = $user->gender === 'male' ? 'female' : 'male';
       
       
       
       // managing RATING status 
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
  
            //fetching beautifull profiless
            $users = User::select('id', 'first_name', 'region', 'dob', 'gender', 'admin_status', 'profile_approval','admin_approve_time')
                    ->with(['receivedRatings', 'images' => function($query) {
                        $query->where('type', 0)
                              ->select('id', 'user_id', 'type', 'profile_image', 'rating');
            }])
            ->where('gender', $oppositeGender)      
            ->orderBy('created_at', 'desc')
            ->get();
            
                // filtering the data 
             $newlyBeautiful = $users->filter(function($user) {
                if ($user->profile_approval == 1) {
                    return true;
                }
                
                // Check if admin approval time + 24 hours has expired
                if ($user->admin_approve_time) {
                    $expireTime = Carbon::parse($user->admin_approve_time)->addHours(24);
                    // If current time is greater than expire time TABHI RATING CHECK KRO
                    if (now()->greaterThan($expireTime)) {

                        $votes = $user->receivedRatings->count();
                        $avgPoints = $user->receivedRatings->avg('points') ?? 0;
                        return $votes >= 4 && $avgPoints > 0;
                    }else {
                    
                        return false;
                    }
                    
               }
            });
            
            foreach ($newlyBeautiful as $user) {
                $user->age = Carbon::parse($user->dob)->age;
                $user->profile_image = optional($user->images->first())->profile_image ?? null;
                unset($user->images);
            }
            
            $newlyBeautiful = $newlyBeautiful->take(5)->values();




            //new applicants
           $newapplicant = User::select('id', 'first_name', 'region', 'dob', 'gender', 'admin_status', 'admin_approve_time','profie_rating_status')
                            ->where('gender', $oppositeGender)
                            ->where('admin_status', 1)
                            ->where('profile_approval', 0)
                            ->where('gender', $oppositeGender)      
                            ->with(['images' => function($query) {
                                $query->where('type', 0)
                                      ->select('id', 'user_id', 'type', 'profile_image', 'rating');
                            }])
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                        
                      $validApplicants = [];
                        
                        
                        $authId = Auth::id();
                       
                    $userRatings = UserRate::where('sender_id', $authId)
                                    ->pluck('reaction', 'reciever_id'); 
                        
                        foreach ($newapplicant as $user) {
                            $expireTime = Carbon::parse($user->admin_approve_time)->addHours(24);
                        
                            if ( now() <= $expireTime) {
                                $user->age = Carbon::parse($user->dob)->age;
                                $user->profile_image = optional($user->images->first())->profile_image ?? null;
                                
                             $user->rating_reaction = $userRatings[$user->id] ?? null;
                             
                                unset($user->images);
                        
                                $validApplicants[] = $user;
                            }
                        }

            // Convert array to collection for sorting
            $validApplicants = collect($validApplicants)
                ->sortBy(function ($user) {
                    // null reactions (no rating) should come first
                    return $user->rating_reaction !== null;
                })
                ->values(); // reindex keys
            
            // Optional: convert back to array if you need plain array
            $validApplicants = $validApplicants->all();
   
   
   
   
         // helper fn for rest of array data
         function appendUserDetails($users) {
                        foreach ($users as $user) {
                            $user->age = Carbon::parse($user->dob)->age;
                            $userImage = UserImage::where('user_id', $user->id)
                                ->where('type', 0)
                                ->value('profile_image'); 
                            $user->profile_image = $userImage;
                        }
                        return $users;
                  }
                    
        // Popular Members
        $popularMembers = User::select('id', 'first_name', 'region', 'dob', 'gender')
                        ->where('admin_status', 1)
                        ->where('gender', $oppositeGender)      
                        ->take(5)
                        ->get();
        $popularMembers = appendUserDetails($popularMembers);
                    
        // Online Members
        $onlineMembers = User::select('id', 'first_name',  'region', 'dob', 'gender')
                        ->where('admin_status', 1)
                        ->where('gender', $oppositeGender)
                        ->where('profie_rating_status','IN')
                        ->where('online_status','online')
                        ->take(5)
                        ->get();
        $onlineMembers = appendUserDetails($onlineMembers);
                    
       // Profile Viewed Members
        $profileViewedMembers = User::select('id', 'first_name',  'region', 'dob', 'gender')
                                ->where('admin_status', 1)
                                ->where('gender', $oppositeGender)      
                                ->take(5)
                                ->get();
                                
        $profileViewedMembers = appendUserDetails($profileViewedMembers);                     
            

     $user = Auth::user();
    //  my status
     $myStatus = UserStatus::with('user:id,profile_image,first_name,gender')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($status) {
                    return [
                        'id' => $status->id,
                        'user_id' => $status->user_id,
                        'post' => $status->post,
                        'image' => $status->image,
                        'status' => $status->status,
                        'created_at' => $status->created_at,
                        'updated_at' => $status->updated_at,
                        'deleted_at' => $status->deleted_at,
                    ];
                });
                 
     //user status
    $userStatuses = UserStatus::with(['user:id,profile_image,first_name,gender'])
                    ->whereHas('user', function($q) use ($oppositeGender) {
                        $q->where('gender', $oppositeGender);
                    })
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy('user_id') 
                    ->map(function($statuses, $userId) {
                        $user = $statuses->first()->user; 
                        if (!$user) return null;
                
                        return [
                            'user' => [
                                'id' => $user->id,
                                'profile_image' => $user->profile_image,
                                'first_name' => $user->first_name,
                                'gender' => $user->gender,
                            ],
                            'stories' => $statuses->map(function($status) {
                                return [
                                    'id' => $status->id,
                                    'user_id' => $status->user_id,
                                    'post' => $status->post,
                                    'image' => $status->image,
                                    'status' => $status->status,
                                    'created_at' => $status->created_at,
                                    'updated_at' => $status->updated_at,
                                    'deleted_at' => $status->deleted_at,
                                ];
                            })->values()
                        ];
                    })
                    ->filter()
                    ->values();


    $data = [
        'user_image'              => $userImage,
        'user_gender'            =>  $user->gender,
        'rating_status'           => $user->profie_rating_status,
        'newly_beautiful_members' => $newlyBeautiful,
        'new_applicants'          => $validApplicants,
        'popular_members'         => $popularMembers,
        'online_members'          => $onlineMembers,
        'profile_viewed_members'  => $profileViewedMembers,
        'user_status'             => $userStatuses,
        'my_status'               =>$myStatus
    ];
        
        
    return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Data retrieved successfully',
            'data' => $data
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 422);
    }
}



public function homeList(Request $request){

    $request->validate(['key'=>'required']);
    $user = Auth::user();

    $oppositeGender = $user->gender === 'male' ? 'female' : 'male';
    
        // managing status 
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
    
   // beautyfull  
    if($request->key == "beautifull_member"){
        
        
        
        
          $users = User::select('*')
                    ->with(['receivedRatings', 'images' => function($query) {
                        $query->where('type', 0)
                              ->select('id', 'user_id', 'type', 'profile_image', 'rating');
            }])
            ->where('gender', $oppositeGender)      
            ->orderBy('created_at', 'desc')
            ->get();
            
                // filtering the data 
             $newlyBeautiful = $users->filter(function($user) {
                if ($user->profile_approval == 1) {
                    return true;
                }
                
                // Check if admin approval time + 24 hours has expired
                if ($user->admin_approve_time) {
                    $expireTime = Carbon::parse($user->admin_approve_time)->addHours(24);
                    // If current time is greater than expire time TABHI RATING CHECK KRO
                    if (now()->greaterThan($expireTime)) {

                        $votes = $user->receivedRatings->count();
                        $avgPoints = $user->receivedRatings->avg('points') ?? 0;
                        return $votes >= 4 && $avgPoints > 0;
                    }else {
                    
                        return false;
                    }
                    
               }
            });
            
            foreach ($newlyBeautiful as $user) {
                // age
                $user->age = Carbon::parse($user->dob)->age;
                // uski best pic
                $user->user_profile_image = optional($user->images->first())->profile_image ?? null;
                unset($user->images);
                unset($user->receivedRatings);
                
                
            }
            
            $newlyBeautiful = $newlyBeautiful->values();
        
        return response()->json(['status'=>true,'status_code'=>200,'message'=>'Data retrieved successfully',
        'profile_rating_status' => $user->profie_rating_status ,'data'=>$newlyBeautiful]);    
        
        
        
    }



    // new user
    if($request->key == "new_applicant"){
        
      
   $newapplicant =    User::select('*')
                            ->where('gender', $oppositeGender)
                            ->where('admin_status', 1)
                            ->where('profile_approval', 0)
                            ->where('gender', $oppositeGender)      
                            ->with(['images' => function($query) {
                                $query->where('type', 0)
                                      ->select('id', 'user_id', 'type', 'profile_image', 'rating');
                            }])
                            ->orderBy('created_at', 'desc')
                            ->get();
                        
                      $validApplicants = [];
                        
                        
                        $authId = Auth::id();
                       
                    $userRatings = UserRate::where('sender_id', $authId)
                                    ->pluck('reaction', 'reciever_id'); 
                        
                        foreach ($newapplicant as $user) {
                            $expireTime = Carbon::parse($user->admin_approve_time)->addHours(24);
                        
                            if ( now() <= $expireTime) {
                                $user->age = Carbon::parse($user->dob)->age;
                                $user->user_profile_image = optional($user->images->first())->profile_image ?? null;
                                
                             $user->rating_reaction = $userRatings[$user->id] ?? null;
                             
                                unset($user->images);
                        
                                $validApplicants[] = $user;
                            }
                        }
        
    
        return response()->json(['status'=>true,'status_code'=>200,'message'=>'Data retrieved successfully',
        'profile_rating_status' => $user->profie_rating_status ,'data'=>$validApplicants]);
    }
    
    // helper fn
    function appendProfileImageAndAge($users) {
        foreach ($users as $user) {
            // Calculate age
            $user->age = Carbon::parse($user->dob)->age;
    
            // Fetch profile image from user_images table (type=0)
            $user->user_profile_image = optional($user->images->first())->profile_image ?? null;
    
            // Remove images relation for clean JSON
            unset($user->images);
        }
        return $users;
    }

    // Popular Members
    if($request->key == "popular_member") {
        $popularMembers = User::where('admin_status',1)
         ->where('gender', $oppositeGender)
            ->with(['images' => function($query) {
                $query->where('type',0); // profile images only
            }])->get();
    
        $popularMembers = appendProfileImageAndAge($popularMembers);
    
        return response()->json([
            'status'=>true,
            'status_code'=>200,
            'message'=>'Data retrieved successfully',
            'profile_rating_status'=>$user->profie_rating_status,
            'data'=>$popularMembers
        ]);
    }

    // Online Members
    elseif($request->key == "online_member") {
        $onlineMembers = User::where('admin_status',1)
         ->where('gender', $oppositeGender)
         ->where('profie_rating_status','IN')
         ->where('online_status','online')
            ->with(['images' => function($query) {
                $query->where('type',0); // profile images only
            }])->get();
    
        $onlineMembers = appendProfileImageAndAge($onlineMembers);
    
        return response()->json([
            'status'=>true,
            'status_code'=>200,
            'message'=>'Data retrieved successfully',
            'profile_rating_status'=>$user->profie_rating_status,
            'data'=>$onlineMembers
        ]);
    }

    // Profile Viewed Members
    elseif($request->key == "profile_view") {
        $profileViewedMembers = User::where('admin_status',1)
         ->where('gender', $oppositeGender)
            ->with(['images' => function($query) {
                $query->where('type',0); // profile images only
            }])->get();
    
        $profileViewedMembers = appendProfileImageAndAge($profileViewedMembers);
    
        return response()->json([
            'status'=>true,
            'status_code'=>200,
            'message'=>'Data retrieved successfully',
            'profile_rating_status'=>$user->profie_rating_status,
            'data'=>$profileViewedMembers
        ]);
    }
    



}


// ********************************view detail *****************************************************************************************
public function viewDetail(request $request){
    try{
        
    $userid = $request->id;
    
   $userImage = UserImage::where('user_id', $userid)
            ->where('type', 0)
            ->value('profile_image');

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
        
        
          // fetching multiple image 
    $bestimages = UserImage::select('id', 'user_id', 'profile_image as gallery_image')
        ->where('user_id', $userid)
        ->where('type', 0)
        ->get();
        

                
    $privateImage = UserImage::select('id', 'user_id', 'profile_image as gallery_image')
        ->where('user_id', $userid)
        ->where('type', 1)
        ->get();
                        
                        
    $name=$user->profile_name;
    
    // rating ka funda
    $yesRatingAvg = UserRate::where('reciever_id', $userid)->where('reaction', 'YES')->count('points') ?? 0;
    $okRatingAvg = UserRate::where('reciever_id', $userid)->where('reaction', 'OK')->count('points') ?? 0;
    $maybeRatingAvg = UserRate::where('reciever_id', $userid)->where('reaction', 'Maybe')->count('points') ?? 0;
    $noRatingAvg = UserRate::where('reciever_id', $userid)->where('reaction', 'No')->count('points') ?? 0;
    $allRatings = UserRate::where('reciever_id', $userid)->get();
    
    
    // similar profile 
    $authuser = Auth::user();
    
    $similar_profile = User::whereIn('id', function($query) use ($authuser) {
        $query->select('reciever_id')
              ->from('user_rating') 
              ->where('sender_id', $authuser->id);
    })
    ->where('id', '!=', $request->id) 
    ->with(['images' => function($q) {
        $q->where('type', 0)
          ->select('id', 'user_id', 'profile_image');
    }])
    ->select('id', 'first_name', 'region', 'dob', 'gender')
    ->get();
    
    $similar_profile->transform(function($user) {
        $user->profile_image = optional($user->images->first())->profile_image ?? null;
        $user->age = Carbon::parse($user->dob)->age;
        unset($user->images);
        return $user;
    });   
    
    
    // view profile datat store
    $viewData = new ViewProfile;
    $viewData->view_id = $request->id;
    $viewData->viewer_id =$authuser->id;
    $viewData->save();
    

    $ratingreaction = UserRate::where('sender_id',$authuser->id)->where('reciever_id',$userid)->value('reaction');
    
   if ($publicimages->isEmpty()) {
        
         $public_images = optional($bestimages->first())->gallery_image ?? null;
    } else {
        $public_images = $publicimages;
    }

    
    // request sended to user or not
    $requestSent = RequestModel::where('request_to', $user)
                    ->where('request_from', $authuser)
                    ->exists(); 
                    
    if ($requestSent) {
        $response = 'yes';
    } else {
        $response = 'no';
    }
    
    

    $data   =[
        "id"          => $user->id,
        "first_name"  => $user->first_name,
        "last_name"   => $user->last_name,
        "city"        =>$user->city,
        "rating_reaction"=>$ratingreaction,
        "age"=>$age,
        "user_image"=> $userImage ,
        "looking_for"=> $lookingforname,
        "rating_status"=>$authuser->profie_rating_status,
        "about"=>[
                    "about_me" => $user->about_me,
                    "about_match" => $user->about_match,
           ],
        "info"=>[
            
                "profile_name" =>$user->profile_name,
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
                "zodiac_sign"=>$user->zodiac_sign,
             ] ,

        "personal_information" =>[
            "smoking"=>$user->smoking,
            "drinking"=>$user->drinking,
            "tattoos"=>$user->tattoos,
            "piercings"=>$user->piercings,
            "relationship_status"=>$user->relationship_status
          ] ,
  
     'ratings' => [
            'hot' => round($yesRatingAvg, 2),
            'ok_avg' => round($okRatingAvg, 2),
            'maybe_avg' => round($maybeRatingAvg, 2),
            'no_avg' => round($noRatingAvg, 2),
            'overall_avg'=>2
        ],
          
         "public_images" => $public_images,
         "private_images" =>$privateImage,
         "similar_profile"=>$similar_profile,
         "requested"=>$response

    ];


    return response()->json(['status'=>true,'status_code' => 200,'message'=>'User Data Retrieve succesfully','data'=>$data],200);
           
    }catch(\Exception $e){
      return response()->json(['status'=>false,'message'=>$e->getMessage()],422);    
    }

}
// ***********************************************************************user rate ********************************************************************************

public function userRate(Request $request)
{
    $request->validate([
        'reciever_id' => 'required',  
        'reaction' => 'required|in:YES,OK,Maybe,No'
    ]);
    

    $user = Auth::user(); 
   
    $pointsMap = [
        'YES' => 2,
        'OK' => 1,
        'Maybe' => -1,
        'No' => -2,
    ];

    $reaction = $request->reaction;
    $points = $pointsMap[$reaction];

    $rate = UserRate::create([
        'sender_id' => $user->id,
        'reciever_id' => $request->reciever_id,
        'reaction' => $reaction,
        'points' => $points,
    ]);

    return response()->json([
        'status' => true,
        'status_code' => 200,
        'message' => 'User rated successfully',
        'data' => $rate
    ]);
}


// *****************************************************************************user status ************************************************************************************

public function userStory(Request $request)
{
    $request->validate([
        'story' => 'nullable|string',
        'image' => 'nullable'
    ]);


    if (!$request->story && !$request->hasFile('image')) {
        return response()->json([
            'status' => false,
            'message' => 'You must upload a story text or an image.',
        ], 422);
    }

    $user = Auth::user();

    $imagePath = null;
    if ($request->hasFile('image')) {
        $img = $request->file('image');
        $name = time() . '.' . $img->getClientOriginalExtension();
        $path = public_path('uploads/story_image');

        // move file
        $img->move($path, $name);

        // store relative path for DB
        $imagePath = 'public/uploads/story_image/' . $name;
    }

    $status = UserStatus::create([
        'user_id' => $user->id,
        'post' => $request->story,
        'image' => $imagePath,
        'status' => 'unseen',
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Status saved successfully!',
        'data' => $status,
    ], 200);
}

//******************************************************************update story status ie seen and unseen ***********************************************************************************  
public function updateStoryStatus(Request $request)
{
    $request->validate([
        'status' => 'required', // seen, unseen
        'id'     => 'required',
    ]);

    $status = UserStatus::find($request->id);

    if (!$status) {
        return response()->json([
            'status' => false,
            'message' => 'Story not found.'
        ], 404);
    }

    $status->status = $request->status;

   
    $status->save();

    return response()->json([
        'status' => true,
        'message' => 'Story status updated successfully',
        'data' => $status
    ]);
}



}
