<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\This;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;


    protected $fillable = [
        'name', 'surname', 'slug', 'email', 'avatar', 'password',
        'address', 'phonenumber', 'bio', 'dateofbirth'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**************Friendly link**************/
    public function slug():string
    {
        return "$this->id-$this->name-$this->surname";
    }

    public function fPage()
    {
        $friends = $this->friends->paginate(4);
        $friends->setPageName('friendPage');

    }

    public function  getProfilePic(){
        if (!File::exists(storage_path("app/public/uploads/$this->id/avatars/" . $this->avatar ))){
            return Storage::url("uploads/avatars/default.jpg");
        }
        return Storage::url("uploads/$this->id/avatars/". $this->avatar);
    }

    /************   post relation  ************/
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    /************  get all posts from self and followers  ************/
    public function getFeed()
    {
        $userIds = $this->follow()->pluck('user_id');
        $userIds[] = $this->id;
        return Post::whereIn('user_id', $userIds)->latest()->paginate(5);
    }

    public function follow()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class,'followers','user_id', 'follower_id');
    }

    public function isFollowing(User $user)
    {
        return $this->follow()->where(['user_id' => $user->id, 'follower_id' => $this->id])->first();
    }

    /**************  Friend request section  ************/
    public function friendRequestsOfThisUser()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot('status')
            ->wherePivot('status', 'pending');
    }

    public function friendRequestsToThisUser()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->withPivot('status')
            ->wherePivot('status', 'pending');
    }

    // friendship that this user started
    public function friendsOfThisUser()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot('status')
            ->wherePivot('status', 'confirmed');
    }

    // friendship that this user was asked for
    public function thisUserFriendOf()
    {
        return  $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->withPivot('status')
            ->wherePivot('status', 'confirmed');
    }

    // accessor allowing you call $user->friends
    public function getFriendsAttribute()
    {
        if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();
        return $this->getRelation('friends');
    }

    protected function loadFriends()
    {
        if ( ! array_key_exists('friends', $this->relations))
        {
            $friends = $this->mergeFriends();
            $this->setRelation('friends', $friends);
        }
    }

    protected function mergeFriends()
    {
        if($temp = $this->friendsOfThisUser)
            return $temp->merge($this->thisUserFriendOf);
        else
            return $this->thisUserFriendOf;
    }

    public function hasSentFriendRequest(User $user)
    {
        return $this->friendRequestsOfThisUser()->where(['user_id' => $this->id, 'friend_id' => $user->id,
            'status'=>'pending'])->first();
    }

    public function hasReceivedFriendRequest(User $user)
    {
        return $this->friendRequestsToThisUser()->where(['user_id' => $user->id, 'friend_id' => $this->id,
            'status'=>'pending'])->first();
    }

    public function areFriends(User $user)
    {
        return
            ($this->friendsOfThisUser()->where(['user_id' => $this->id, 'friend_id' => $user->id,
                'status'=>'confirmed'])->first() ||
            $this->thisUserFriendOf()->where(['user_id' => $user->id, 'friend_id' => $this->id,
                'status'=>'confirmed'])->first()
        );
    }

    public function isFriendWith(User $user)
    {
        return $this->friendsOfThisUser()->where(['user_id' => $this->id, 'friend_id' => $user->id,
            'status'=>'confirmed'])->first();
    }

    public function isFriendOf(User $user)
    {
        return $this->thisUserFriendOf()->where(['user_id' => $user->id, 'friend_id' => $this->id,
            'status'=>'confirmed'])->first();
    }


    /**************  Gallery section  ************/

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

}
