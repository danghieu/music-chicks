@extends('main')
@section('title')
Home page
@endsection

@section('content')

<script src="{{Asset('../resources/assets/js/musicplayer.js')}}"></script>

@if($userlevel!=2)
<script src="{{Asset('../resources/assets/js/musicsync-admin-slave.js')}}"></script>
@endif

@if($userlevel==3)
<script src="{{Asset('../resources/assets/js/musicsync-slave.js')}}"></script>
@endif

<script src="{{Asset('../resources/assets/js/musicsync.js')}}"></script>

<script src="{{Asset('../resources/assets/js/settime.js')}}"></script>

<script src="{{Asset('../resources/assets/js/clock.js')}}"></script>
<link rel="stylesheet" href="{{Asset('../resources/assets/audio/css/stylesheet.css')}}">
<script type="text/javascript">
	var userlevel = {{$userlevel}};
</script>


<style type="text/css">
.playlist_control{
	width: 300px;
	margin: 10px auto 10px auto;
}
.playlist-control{
	width: 500px;
	margin: 15px auto 10px auto;
	float: left;
}
input[type="range"] {
	width: 250px;
	margin-top: -5px;
} 
</style>



<div class=" col-sm-12">
	@if(Session::get("userlevel")!=3)
	<div class=" col-sm-7">
	@else <div class="col-sm-offset-2 col-sm-7">
	@endif
		<div id="audio-player col-sm-12">
			<div class="player">
				<audio id="nowplaying" src="">
					<p>Trình duyệt của bạn không hỗ trợ HTML5 Audio</p>
				</audio>
				
				<div class="player__loading">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>			
				</div>
				<div class="player__control">
					<button id="playPause" class="fa fa-play player--play"></button>
					<button id="btn-stop-admin" class="fa fa-stop player--play"></button>
					<button id="ffwd" class="fa fa-fast-forward player--play"></button>

					<span id="currentTime">00:00</span>
					<input id="seek" class="player--seek" type="range" min="0" max="3600" value="0">
					<span id="durationTime">00:00</span>
					@if(Session::get("userlevel")!=3 && Session::get("userlevel")!=2)
					<div class="dropdown " style="float: right;margin-right: 30px; margin-top: 2px;">
						<button  id="btn-mute" class=" player--volumn icon-volume-high dropdown-toggle btn-menu" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						</button>

						<ul class="dropdown-menu my-dropdown-menu-mute menu_control" aria-labelledby="dropdownMenu1">
	                       <button id="muted-local" class=" player--volumn icon-volume-high-local" type="button"></button>
	                       <button id="muted-slave" class=" player--volumn icon-volume-high-slave" type="button" ></button>
                        </ul>
					</div>
					<div style="display: none;">
						<button id="muted" class=" player--volumn icon-volume-high" type="button"></button>
					</div>
					@else
					<div class="dropdown " style="float: right;margin-right: 30px; margin-top: 2px; display: none;">
						<button  id="btn-mute" class=" player--volumn icon-volume-high dropdown-toggle btn-menu" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						</button>

						<ul class="dropdown-menu my-dropdown-menu-mute menu_control" aria-labelledby="dropdownMenu1">
	                       <button id="muted-local" class=" player--volumn icon-volume-high-local" type="button"></button>
	                       <button id="muted-slave" class=" player--volumn icon-volume-high-slave" type="button" ></button>
                        </ul>
					</div>
						<button id="muted" class=" player--volumn icon-volume-high" type="button"></button>
					@endif
				</div>
			</div><!-- end player -->
		</div>

		<div class="table-body chart"></div>
	</div>
	
		@if(Session::get("userlevel")!=3)
		<div class="col-sm-4">
			<div class="clockview"></div>

			@if(Session::get("userlevel")!=2)
			<div class=" settime"></div>
			@endif
			
			<div class="votedsongs"></div>
		<div class="col-sm-4">
		@endif
</div>

@endsection