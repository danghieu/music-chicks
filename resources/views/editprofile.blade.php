@extends('main')
@section('title')
Edit Profile
@endsection
@section('content')
<script src="{{Asset('../resources/assets/js/editprofile.js')}}"></script>
<div class="col-md-12 ">
   
    
     <div class="row ">
        <div class="edit_profile">
          <h2>General Account Settings</h2></div><hr>
           @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @elseif (Session::has('success'))
             <div class="alert alert-success">
              <li>{{ Session::get('success') }}</li>
            </div>
              
            @endif
          <form method="post" action="{{Asset('edit')}}" id="form_upload" name="form_upload" enctype="multipart/form-data" >
            <div class="col-xs-6">
                  <h4><span class="label label-warning">Name</span></h4>
                  <p>Name: <span class="infor">{{$user->name}}</span></p>
                  <hr>
                  <input type="text" class="form-control" name="name" placeholder="New Name"><br>
                  <hr>
                  <h4><span class="label label-warning">Password</span></h4>
                  
                  <hr>
                  <p>Current</p>
                  <input type="password" id="current" name="current" class="form-control">
                  <p>New</p>
                  <input type="password" id="new" name="new" class="form-control">
                  <p>Retype</p>
                  <input type="password" id="retype" name="retype" class="form-control">
                </div>
                <div class="col-xs-6">
                  <h4><span class="label label-warning">Email</span></h4>
                  <p>Email:  <span class="infor">{{$user->email}}</span></p>
                  <hr>
                  <input type="email" class="form-control" name="email" placeholder="New email"><br>
                  <hr>
                  <h4><span class="label label-warning">Avatar</span></h4><hr>
                  <p>Avatar</p>
                  <div class="img-thumbnail">
                    <img src="{{$avatar}}" class="thumb ">
                  </div><br>
                  <div class="form-group">                    
                        <input type="file" name="image" id="image"/>  
                   </div>

              </div>
            </div>
                <hr>
                  <div class="form-group float-right">
                        <input type="submit" name="submit" value="Save change" id="submit" class="btn btn-primary btn-sm active">
                        <a href="{{'home'}}"><input type="button" name="cancel" value="Cancel" id="cancel" class="btn btn-default btn-bg"></a>    
                         </div>
                </div>
      </form>
    </div>
       
@endsection
