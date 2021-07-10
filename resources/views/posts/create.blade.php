@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/p" 
          enctype="multipart/form-data" 
          method="post">
        @csrf
        <div class="row">
            {{-- col-8 offset-2, center, but leave left and right empty with each col-1 --}}
            <div class="col-8 offset-2"> 
                <div class="row">
                    <h1>Add New Post</h1>
                </div>
                <div class="form-group row">
                    <label for="caption" class="col-md-4 col-form-label">Post Caption</label>
                    <input id="caption" 
                           type="text" 
                           class="form-control @error('caption') is-invalid @enderror" 
                           name="caption" 
                           value="{{ old('caption') }}" 
                           required
                           autocomplete="caption" autofocus>
    
                    @error('caption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>  
    
                <div class="row">
                    <label for="caption" class="col-md-4 col-form-label">Post Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    
                    @error('image')
                        <strong>{{ $message }}</strong>
                    @enderror
                </div>
    
                <div class="row pt-4">
                    <input type="submit" name="submit_data" value="SUBMIT"/>
                    {{-- <button class="btn btn-primary">
                        Add New Post
                    </button> --}}
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
