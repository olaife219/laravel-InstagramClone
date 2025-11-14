<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
// use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Gd\Driver;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class ProfileController extends Controller
{

    public function index($user)
    {
        $user = User::findOrFail($user);

        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postCount = Cache::remember(
            'count.posts.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
            return $user->posts->count();
        });

        $followersCount = Cache::remember(
            'count.followers.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
            return $user->profile->followers->count();
        });

        $followingCount = Cache::remember(
            'count.following.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
            return $user->following->count();
        });

        return view('profile.index', [
            'user' => $user,
            'follows' => $follows,
            'postCount' => $postCount,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // $this->authorize('update', $user->profile);
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        $user->profile->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'url' => $request->input('url'),
        ]);

        // if ($request->file('image')) {
        //     $imagePath = $request->file('image')->store('profile', 'public');

        //     $manager = new ImageManager(new Driver());
        //     $image = $manager->read(public_path("storage/{$imagePath}"));
        //     $image->resize(1000, 1000)->save();
        //     $user->profile->update(['image' => $imagePath] ?? []);
        // }

        if ($request->hasFile('image')) {

            $uploadedImageUrl = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                [
                    'folder' => 'profiles',
                    'transformation' => [
                        'width' => 1000,
                        'height' => 1000,
                        'crop' => 'fill'
                    ]
                ]
            )->getSecurePath();

            $user->profile->update([
                'image' => $uploadedImageUrl,
            ]);
        }


        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
