<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use  App\Models\{User,HearAboutUs,LookngFor,UserImage,UserIntrest,CountryCode,Nationality,Region,City,BodyType,SexOrientation,Zodiac,RequestModel,UserLike};

class UserController extends Controller
{
    
// ***********************************************selfie  image for user ************************************************************************************
    public function profileImage(request $request){
        try{

             $rule =[
                'profile_image'=>'required' ,
                
                ];

                $validator = Validator::make($request->all(),$rule);
                if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
                }
            
         
              $user = Auth::User();

             if($request->has('profile_image')){
                $image = $request->profile_image;
                $name  = time().'.'.$image->getClientOriginalExtension();
                $path = public_path('uploads/users/');
                $image->move($path,$name);
                $user->profile_image = 'public/uploads/users/'.$name;
                $user->save();     
                };
            return response()->json(['status' => true, 'status_code' => 200, 'message' => "profile image uploded succesfully", 'data' => $user], 200);

            }catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => $e->getMessage()], 422);
                }
                
    }

// ***********************************************************USER Image *************************************************************************
public function userImage(Request $request)
{
    try {
        $rule = [
            'user_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'message' => $validator->errors()->first()
            ], 422);
        }

      $user = Auth::User();

        if ($request->hasFile('user_image')) {
            $image = $request->file('user_image');
            $name  = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/public_image/');

    
            $image->move($path, $name);

            $savedImage = UserImage::create([
                'user_id' => $user->id,
                'profile_image' => 'public/uploads/public_image/' . $name,
            ]);

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => "User image uploaded successfully",
                'data' => $savedImage
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'No image found in request'
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false, 
            'message' => $e->getMessage()
        ], 422);
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

           $user = Auth::User();
      
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


// *********************************************************api to get hear abt us ********************************************************************

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


      $user = Auth::User();
       
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
// ******************************************************************* get lookingFor *********************************************************************
public function getLookingFor(){
    $data = LookngFor::get();
    return response()->json([
            "status_code"=>200,
            "status" => true,
            "message" => " LookngFor  detail retrive successfully",
            "data" => $data
        ], 200); 

}

// ************************************************************************store looking for ********************************************************

public function lookingFor(request $request){

    try{
            $request->validate([
                    'looking_for_ids' => 'required', 
                
            ]);

                $user = Auth::User();
       
            $ids = $request->looking_for_ids;  
            // converting into string and save
            $user->looking_for = implode(',',$ids);
            $user->save();

        return response()->json([
                        "status_code"=>200,
                        "status" => true,
                        "message" => " Data save successfully",
                        "data" => $user
                    ], 200); 
        }catch(\Exception $e){
                return response()->json([
                        "status" => false,
                        "message" => $e->getMessage()
                    ], 500);
            }



}

// ****************************************************************************gender save*********************************************************************

    public function gender(Request $request)
    {
        try {
            $request->validate([
                "Gender" => "required",
         
            ]);
    
          
                 $user = Auth::User();
       
    
            $user->gender = $request->Gender;
            $user->save();
    
            return response()->json([
                "status_code" => 200,
                "status"      => true,
                "message"     => "Gender saved successfully",
                "data"        => $user
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => $e->getMessage()
            ], 500);
        }
}

// *******************************************************************store USER INTREST *************************************************************************

        public function userIntrest(Request $request)
        {
            try {
             
      
                 $user = Auth::User();
                if (!$user) {
                    return response()->json([
                        "status"  => false,
                        "message" => "Unauthorized access",
                    ], 401);
                }
    
             $data = UserIntrest::create([
                'user_id'     => $user->id,
                'fav_music'   => $request->fav_music,
                'fav_tv_show' => $request->fav_tv_show,
                'fav_movie'   => $request->fav_movie,
                'fav_book'    => $request->fav_book,
                'fav_sport'   => $request->fav_sport,
                'other'       => $request->other,
            ]);
        
           $data->refresh();
            return response()->json([
                    "status_code" => 200,
                    "status"      => true,
                    "message"     => "User Interest saved successfully",
                    "data"        => $data
                ], 200);
    
            } catch (\Exception $e) {
                return response()->json([
                    "status"  => false,
                    "message" => $e->getMessage()
                ], 500);
            }
        }
    

// *****************************************************************************country code****************************************************************************************************
    
   public function countryCode(){
        $data = CountryCode::get();
        return response()->json([
                "status_code"=>200,
                "status" => true,
                "message" => "Data detail retrive successfully",
                "data" => $data
            ], 200); 
    
    }


// *****************************************************************************nationality ****************************************************************************************************
    
   public function Nationality(){
        $data = Nationality::orderBy('nationality', 'asc')->get();;
        return response()->json([
                "status_code"=>200,
                "status" => true,
                "message" => "Data detail retrive successfully",
                "data" => $data
            ], 200); 
    
    }

// ********************************************************************************get region ***************************************************************************************************

  public function getRegion(){
        $data = Region::get();
        return response()->json([
                "status_code"=>200,
                "status" => true,
                "message" => "Region retrive successfully",
                "data" => $data
            ], 200); 
    
    }

 public function getCity(request $request){

     
  $request->validate([
    'region_id'=>'required'
 ]);
         

   $region_id = $request->region_id;


   $data = City::where('region_id', $region_id)->orderBy('city','asc')->get();

        return response()->json([
                "status_code"=>200,
                "status" => true,
                "message" => "City retrieved successfully.",
                "data" => $data
            ], 200); 
   
         
   
 }


public function bodyType(){
   $data = BodyType::get();
        return response()->json([
                "status_code"=>200,
                "status" => true,
                "message" => "Body Type retrive successfully",
                "data" => $data
            ], 200); 
    
}



public function sexOrientation(){
   $data = SexOrientation::get();
        return response()->json([
                "status_code"=>200,
                "status" => true,
                "message" => "SexOrientationretrive successfully",
                "data" => $data
            ], 200); 
    
}



public function zodiacSign(){
   $data = Zodiac::get();
        return response()->json([
                "status_code"=>200,
                "status" => true,
                "message" => "Zodiac data ritreve successfully",
                "data" => $data
            ], 200); 
    
}


// ****************************************************************************gallery image **********************************************************************************************

public function galleryImages(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'user_image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = Auth::user();
        $savedImages = [];

        $images = $request->file('user_image');

     
        if (!is_array($images)) {
            $images = [$images];
        }

        $uploadedFileNames = []; 

        foreach ($images as $image) {

           
            $hash = md5_file($image->getRealPath());

           
            if (in_array($hash, $uploadedFileNames)) {
                continue;
            }

            $uploadedFileNames[] = $hash;

          
            $name = time() . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/public_image/');
            $image->move($path, $name);

           
            $savedImages[] = UserImage::create([
                'user_id' => $user->id,
                'type' => 2,
                'profile_image' => 'public/uploads/public_image/' . $name,
            ]);
        }

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => "Gallery images uploaded successfully",
            'data' => $savedImages,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage(),
        ], 422);
    }
}

    



// *******************************************************************************request private access******************************************************************************
public function requestPrivateAccess(Request $request)
{
    // Validate input
    $request->validate([
        'id' => 'required' // make sure the target user exists
    ]);


    $authUserId = Auth::id();

    $userAccess = new RequestModel(); 
    $userAccess->request_to = $request->id;
    $userAccess->request_from = $authUserId;
    $userAccess->save();

    return response()->json([
        'code' =>200,
        'status' => true,
        'message' => 'Private access request sent successfully'
    ]);
    
}
// *****************************************************************************request list ***********************************************************************************
public function requestList(Request $request)
{
    
    $request->validate([
        'key' => 'required', // expecting "confirm" or "pending"
    ]);
    $user = Auth::user();
    
    
if($request->key == 'pending'){
    $requests = RequestModel::with([
                'sender' => function ($q) {
                    $q->select('id', 'first_name');
                },
                'sender.images' => function ($q) {
                    $q->where('type', 0)->select('id', 'user_id', 'profile_image');
                }
            ])
            ->where('request_to', $user->id)
            ->where('status', $request->key)
            ->get();
            
    $requests =    $requests->map(function ($req) {
                    if ($req->sender) {
                        if ($req->sender->images->isNotEmpty()) {
                            $req->sender->image = $req->sender->images->first()->profile_image;
                        } else {
                            $req->sender->image = null;
                        }
    
          
                            unset($req->sender->images);
                        }
                        return $req;
                    });
                            
            return response()->json([
            'code' => 200,
            'status' => true,
            'message' => ucfirst($request->key) . ' requests fetched successfully',
            'data' => $requests,
        ]);                
                
}

// confirm
if($request->key == 'confirm'){
    $requests = RequestModel::with([
                'sender' => function ($q) {
                    $q->select('id', 'first_name');
                },
                'sender.images' => function ($q) {
                    $q->where('type', 0)->select('id', 'user_id', 'profile_image');
                }
            ])
            ->where('request_to', $user->id)
            ->where('status', $request->key)
            ->get();
            
    $requests =    $requests->map(function ($req) {
                    if ($req->sender) {
                        if ($req->sender->images->isNotEmpty()) {
                            $req->sender->image = $req->sender->images->first()->profile_image;
                        } else {
                            $req->sender->image = null;
                        }
    
          
                            unset($req->sender->images);
                        }
                        return $req;
                    });

    return response()->json([
        'code' => 200,
        'status' => true,
        'message' => ucfirst($request->key) . ' requests fetched successfully',
        'data' => $requests,
    ]);
    
    
}   
    
    
    
}
// ********************************************************************************accept request for private access*****************************************************************
public function acceptRequest(Request $request)
{
    $request->validate([
        'request_id' => 'required', 
        'key' => 'required|in:confirm,delete',  
    ]);

    $requestData = RequestModel::where('id',$request->request_id)->first();

    if (!$requestData) {
        return response()->json([
            'code' => 404,
            'status' => false,
            'message' => 'Request not found.',
        ], 404);
    }

    if ($request->key === 'confirm') {
        $requestData->status = 'confirm';
        $requestData->save();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Request accepted successfully.',
        ]);
    }

    if ($request->key === 'delete') {
        $requestData->delete();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Request deleted successfully.',
        ]);
    }
}


// *****************************************************************************like user ********************************************************************************************
public function likeUser(request $request){
    
        $request->validate([
            'like_to' => 'required' // make sure the target user exists
        ]);

        $authUserId = Auth::id();
        $userAccess = new UserLike(); 
        $userAccess->like_by = $authUserId;
        $userAccess->like_to = $request->like_to;
        $userAccess->save();
    
        return response()->json([
            'code' =>200,
            'status' => true,
            'message' => 'User Like successfully'
        ]);
        
}

// *********************************************************************************like user list ********************************************************************
public function likeUserList(){
    
    
    $user = Auth::User();
    $data = UserLike::where('like_to', $user->id)
            ->with('likeByUser:id,first_name,profile_image,city,height,weight') 
            ->get();
    
     return response()->json([
            'code' =>200,
            'status' => true,
            'message' => 'User Like data retrieve successfully',
            'data'=>$data
        ]);
    
}

// ******************************************************************************************add to favourite**************************************************************

public function addFavourite(){
    
    
 $request->validate([
        'fav_to' => 'required' 
    ]);  



    
}
































   
}



























