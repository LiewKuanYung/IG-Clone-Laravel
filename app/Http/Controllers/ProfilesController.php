<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($user) 
    {
        /**
         * try this function for dev, dd(), called die and dump 
         * echo out what is inside and stop all other operation
         * useful to check what being passed in, in the route
         * try
         * dd($user);
         * dd(User::find($user));
         */
        
         ### Code Explanation ###
        
        /**
         * 1. the $user which is the id is passed in into index function
         * 2. Then, User::find($user) to look for data, and assign it back to $user
         * 3. Last, pass the data into view (by adding second array as variable)
         */ 


        $user = User::findOrFail($user); //find() changed to findOrFail()

        /**
         * NEW Content
         * vue.js for follow features
         * Check whether the auth->user's following contains $user
         * true if contains this $user (following) 
         * false if not contains this $user (not following)
         */

        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        // Make use of cach
        $postCount = Cache::remember( //can rememberForever
            'count.post.' .$user->id, 
            now()->addSeconds(30),  //can addDay() addWeek() addMonth()
            function() use ($user) {
                return $user->posts->count();
        });
        $followersCount = Cache::remember( 
            'count.post.' .$user->id, 
            now()->addSeconds(30), 
            function() use ($user) {
                return $user->profile->followers->count();
        });

        // Just for fun! 
        if ($user->id == 3)
        {
            $followersCount += 21800;
        }
        if ($followersCount > 1000)
        {
            $followersCount = (round($followersCount/100))/10 . "k";
        }

        $followingCount = Cache::remember( 
            'count.post.' .$user->id, 
            now()->addSeconds(30), 
            function() use ($user) {
                return $user->following->count();
        });

        return view('profiles.index', [
            'user' => $user,
            'follows' => $follows,
            'postCount' => $postCount,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
        ]);
        /**
         * Take note that this upper part can be changed to a more cleaner code,
         * but will keep it unchanged for record purpose
         */
    }

    public function edit(User $user) //need no to include \App\Models\User because already imported at top, the 'use" 
    {
        //unable to access this function if not logged in
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    //update profile content
    public function update(User $user)
    {
        //unable to access this function if not logged in
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        //if the request have an image
        if(request('image'))
        {
            //this part is same as postscontroller
            $imagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            //array for $data to be merged
            $imageArray = ['image' => $imagePath];
        }

        // check the location of the file
        // dd(array_merge(
        //     $data,
        //     ['image' => $imagePath]
        // ));

        // The safer route is to safe it through authentic user
        // instead of just $user->profile->update($data); we can access through auth
        // like this 
        // auth()->user()->profile->update($data);
        // After that, we need to include image as well, so we use array_merge
        //array_merge take any number of array, and then append them together
        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? [] //if imageArray exist, pass it in, else pass [] in
        ));

        return redirect("/profile/{$user->id}");
    }
}
