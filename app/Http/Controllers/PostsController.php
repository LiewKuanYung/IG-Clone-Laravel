<?php

namespace App\Http\Controllers;

use \App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        //Login to access this page
        $this->middleware('auth');
    }

    public function index()
    {
        // $users = auth()->user()->following()->pluck('user_id');
        // above codes will return "General error: 1 ambiguous column name: user_id"
        // that's because there are many user_id, the system dunno which to choose

        //fetch all the profile that this.user is following
        $users = auth()->user()->following()->pluck('profiles.user_id');

        //fetch all the posts the from profile that this.user is following
        // $posts = Post::whereIn('user_id', $users)->orderBy('created_at', 'DESC')->get(); //(where the user_id is in $users list that we just get)->go and get(in desceinding order)
        // a more simplify command

        $posts = Post::whereIn('user_id', $users)->latest()->with('user')->paginate(5); //changed get() to pagination()... it's so easy...
                                                        //with('user) solves the n+1 problem

        // dd($posts);

        // return view of posts
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create'); //can use posts.create || posts/create but the doc uses dot "."
    }

    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],// 'required|image'
            //'another_field' => ''; // field that passed into $data but don't need validate
        ]);

        //return the path of the image stored
        //it is actually inside storage/app/public/uploads/file.png
        $imagePath = request('image')->store('uploads', 'public');
        dd($imagePath);
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        // The data of the post need to be saved
        // $post = new \App\Models\Post();
        // $post->caption = $data['caption'];
        // $post->save();
        // But there's an easier way to do above process, the Post::create way
        //\App\Models\Post::create($data);

        // Before Post::create executed, 
        // The server needs to know whether is this post valid (user logged in)
        // To achieve this, it is better to update database through relationship
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath, //since the path is diff now, need explicitly state this, no more $data
        ]); //create post through authenticated user

        //check what request
        //dd(request()->all());

        return redirect('/profile/'. auth()->user()->id);
    }

    public function show(\App\Models\Post $post) 
    { // since this.$post is same as $post in web.php (that are being passed into here)
      // by adding \App\Post the laravel will treat $post as the data in the model
      // it also has findOrFail features in it.
      //dd($post);

        // return view('posts.show', [
        //     'post' => $post,
        // ]);

        // Alternative method, can pass many field as well
        return view('posts.show', compact('post'));
    }

    public function delete(\App\Models\User $user)
    {
        //dd($user);
    }
}
