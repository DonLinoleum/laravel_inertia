<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        return Inertia::render("Profile/Index",['title'=>"Мега профиль"]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);

        $fullUrl = $this->profileService->updateAvatar($request->file('avatar'));
        return redirect()->back()->with(['success'=> $fullUrl]);
    }
}
