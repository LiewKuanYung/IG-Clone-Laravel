@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="{{ $user->profile->profileImage() }}" alt="Profile Picture" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <h3>{{ $user->username }}</h3>
                    
                    {{-- user-id is a property in vue, in vue, you can has as much property as possible--}}
                    <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                                                                {{-- follows is a default state --}}
                </div>
                @can('update', $user->profile)
                    <a href="/p/create">Add New Post</a>
                @endcan
            </div>

            @can('update', $user->profile) {{--profile model policy--}}
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div class="pr-5"><strong>{{ $postCount }}</strong> post</div>
                <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>
                <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url ?? 'N/A' }}</a></div>
        </div>
    </div>

    <div class="row pt-5">
        @foreach($user->posts as $post)
            <div class="col-4 pd-4 pb-2">
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" alt="Post Image" class="w-100">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
