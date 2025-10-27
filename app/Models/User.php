<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'profie_rating_status',
        'height',
        'weight',
        'body_type',
        'hair_color',
        'eye_color',
        'nationality',
        'region',
        'city',
        'sexual_orientation',
        'education',
        'field_of_work',
        'relationship_status',
        'zodiac_sign',
        'smoking',
        'drinking',
        'tattoos',
        'piercings',
        'about_me',
        'about_match',
    ];


    public function images()
    {
        return $this->hasMany(UserImage::class, 'user_id', 'id');
    }
    
    public function receivedRatings(){
        
        return $this->hasMany(UserRate::class, 'reciever_id');
        
    }

   public function intrest(){
        
        return $this->hasOne(UserIntrest::class, 'user_id','id');
        
    }
    
    
    



    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'admin_status'=>'boolean'
        ];
    }
}
