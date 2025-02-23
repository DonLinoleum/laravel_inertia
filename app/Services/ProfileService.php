<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function updateAvatar ($file): string
    {
        $path = $file->store('avatars','public');
        $user = auth()->user();
        if ($user->avatar){
            dd($user->avatar);
             $oldAvatarPath = str_replace("/storage/",'',$user->avatar);   
             if (Storage::disk('public')->exists($oldAvatarPath)){
                Storage::disk('public')->delete($oldAvatarPath);
             }
        }
        
        $fullUrl = Storage::url($path);
        $user->update(['avatar'=>$fullUrl]);
        $user->save();
        return $fullUrl;
    }
}