<h2>Users Manager</h2>           
  <table class="table table-striped">
    <thead>
      <tr>
      	
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Avatar</th>
        <th>Level</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
      <tr>
      
        <td>{{$user->id}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td><img class="avatar-img"src="{{$user->avatar}}"></td>
        <td>
        <div class="edit-level">
          <div  class="dropdown" id="{{$user->id}}">
            @if($user->level==0)
                <span class="font-bold title-super">Super Admin</span>
            @elseif($user->level==1)
              @if(Session::get('userlevel')==0)
                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownLevel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <span class="font-bold title-admin">Admin</span>
                </button>
                <ul class="dropdown-menu my-dropdown-menu dropdown-level" aria-labelledby="dropdownLevel">
                    <li><a href="#" class="btn-level" id="user"><span class="font-bold title-user">User</span></a></li>
                    <li><a href="#" class="btn-level" id="slave"><span class="font-bold title-slave">Slave</span></a></li>
                </ul>
              @else
                <span class="font-bold title-admin">Admin</span>
              @endif
            @elseif($user->level==2)
              
                <button class="btn btn-default  dropdown-toggle" type="button" id="dropdownLevel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <span class="font-bold title-user">User</span>
                </button>
                @if(Session::get('userlevel')==0)
                <ul class="dropdown-menu dropdown-level" aria-labelledby="dropdownLevel">
                    <li><a href="#" class="btn-level" id="admin"><span class="font-bold title-admin">Admin</span></a></li>
                    <li><a href="#"class="btn-level" id="slave"><span class="font-bold title-slave">Slave</span></a></li>
                </ul>
                @else
                <ul class="dropdown-menu my-dropdown-menu dropdown-level" aria-labelledby="dropdownLevel">
                    <li><a href="#" class="btn-level" id="slave"><span class="font-bold title-slave">Slave</span></a></li>
                </ul>
                @endif

                 
            @elseif($user->level==3) 
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownLevel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <span class="font-bold title-slave">Slave</span>
                </button>
                @if(Session::get('userlevel')==0)
                <ul class="dropdown-menu dropdown-level" aria-labelledby="dropdownLevel">
                    <li><a href="#" class="btn-level" id="admin"><span class="font-bold title-admin">Admin</span></a></li>
                    <li><a href="#" class="btn-level" id="user"><span class="font-bold title-user">User</span></a></li>
                </ul> 
                 @else
                <ul class="dropdown-menu dropdown-level my-dropdown-menu" aria-labelledby="dropdownLevel">
                    <li><a href="#" class="btn-level" id="user"><span class="font-bold title-user">User</span></a></li>
                </ul>
                @endif      
            @endif
          </div><!--dropdown -->
        </div>
        
        
      
        </td>
        <td >
        @if($user->active==1)
          @if($user->level==0)
            <span class="font-bold active">Active </span>
          @elseif(Session::get('userlevel')==0)  
            <a class="btn btn-default btn-status"  id="{{$user->id}}" href="#"><span class="font-bold active">Active </span></a>   
          @elseif(Session::get('userlevel')==1)
            @if($user->level!=1)
                <a class="btn btn-default btn-status"  id="{{$user->id}}" href="#"><span class="font-bold active">Active </span></a>
            @else
              <span class="font-bold active">Active </span>
            @endif
          @endif
        @elseif($user->active==0)
          @if($user->level==0)
            <span class="font-bold block">Block </span>
          @elseif(Session::get('userlevel')==0)  
            <a class="btn btn-default btn-status"  id="{{$user->id}}"href="#"><span class="font-bold block">Block </span>  </a>
          @elseif(Session::get('userlevel')==1)
            @if($user->level!=1)
            <a class="btn btn-default btn-status"  id="{{$user->id}}"href="#"><span class="font-bold block">Block </span>  </a>
            @else
              <span class="font-bold block">Block </span>
            @endif
          @endif
        @endif
        </td>
        <td></td>
      </tr>
    @endforeach
    </tbody>
  </table>