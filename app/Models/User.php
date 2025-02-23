<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id', 'id', 'id')
            ->wherePivot('accepted,true')
            ->withPivot('user_id', 'friend_id', 'accepted')
        ;
    }

    public function getAllFriends()
    {
        return DB::table("users")
            ->join('friends', 'users.id', '=', 'friends.friend.id')
            ->where('friends.user_id', "=", $this->id)
            ->where('friends.accepted', true)
            ->select('users.*', 'friends.user_id as pivot_user_id', 'friends.friend_id as pivot_friend_id', 'friends.accepted as pivot_accepted')
            ->union(
                DB::table("users")
                    ->join('friends', 'users.id', '=', 'friends.user_id')
                    ->where('friends.friend_id', "=", $this->id)
                    ->where('friends.accepted', true)
                    ->select('users.*', 'friends.user_id as pivot_user_id', 'friends.friend_id as pivot_friend_id', 'friends.accepted as pivot_accepted')
            )->get()
        ;
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id', 'id', 'id')
            ->wherePivot('accepted', false)
        ;
    }

    public function subscriptions()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id', 'id', 'id')
            ->wherePivot('accepted', false)
        ;
    }

    public function allUsersExcludingRelations()
    {
        $currentUserId = $this->id;
        $friendsIds = $this->friends()->pluck('friend_id');
        $friendsIdsAsFriend = DB::table('friends')->where('friend_id', $currentUserId)->where('accepted', true)->pluck('user_id');

        $subscribersIds = $this->subscribers()->pluck('user_id');
        $subscriptionsIds = $this->subscriptions()->pluck('friend_id');

        $excludedIds = $friendsIds->merge($friendsIdsAsFriend)->merge($subscribersIds)->merge($subscriptionsIds)->push($currentUserId);
        return User::query()->whereNotIn('id', $excludedIds)->orderBy('name')->get();
    }


}
