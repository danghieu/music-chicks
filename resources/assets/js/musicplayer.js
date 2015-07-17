var admin_play = false;
var user_play = false;
var playing = false;
var zingid = '';
var _songindex = 0;
var player = document.getElementById('nowplaying'),
	playLoading = document.querySelectorAll('.player__loading span'),
	playPause = document.getElementById('playPause'),
	btnStop = document.getElementById('btn-stop-admin'),
	currentTime = document.getElementById('currentTime'),
	seek = document.getElementById('seek'),
	durationTime = document.getElementById('durationTime'),
	muted = document.getElementById('muted'),
	muted_local = document.getElementById('muted-local'),
	muted_slave = document.getElementById('muted-slave'),
	timeInterval,
	i, 
	len = playLoading.length;

var seeking = false;
var songNumber = -1;

function isAdmin () {
	 var level = userlevel;
	 if(level==1 || level==0)
	 	return true;
	 return false;
}

function play_song (song_index, playnow) {
	_songindex = song_index;
	var current_song = $(".song").eq(song_index);
	if(current_song != null)
	{
		zingid = current_song.data('zingid');
		$.ajax({
			url: "getlink",
			type: "get",
			data: {"zingid":zingid},
			success: function (response) {
				if(response!="failed")
				{	
					$("#nowplaying").attr('src',response);
					if(playnow == undefined || playnow)
						player.play();
					else {
						player.load();
						timeUpdateMusic();
					}
				}
			}
		});
	}
}

function adminPlay (playnow) {
	play_song(0,playnow);
	//admin_play=true;
}

// Play and Pause Music
function playPauseMusic() {
	var i, len = playLoading.length;
	if (player.paused) {
		if(player.currentTime==0)
		{
			if(isAdmin()) {
				adminPlay();
				playing = true;
				socket.emit('play music');
			}
		}
		else
		{
			if(admin_play && isAdmin())
				socket.emit('unpause music');
			player.play();
		}
	} else {
		if(isAdmin())
			socket.emit('pause music');
		player.pause();
	}
}

function stopMusic () {
	player.pause();
	player.currentTime=0;
	timeUpdateMusic();
	$('.artist-avatar').children().removeClass('pausing');
	$('.artist-avatar').children().removeClass('playing');
	//if(isAdmin()) admin_play = false;
}

// Seek Music
function seekMusic() {
	console.log('seek change to '+seek.value);
	if(admin_play && isAdmin())
		socket.emit('change currentTime',seek.value);
	player.currentTime = seek.value;
	if(player.paused)
		timeUpdateMusic();
}

// Muted Music
function mutedMusic_slave() {
	if($(".icon-volume-mute-slave").length>0) {
		muted_slave.classList.remove('icon-volume-mute-slave');
		muted_slave.classList.add('icon-volume-high-slave');
	} else {
		muted_slave.classList.remove('icon-volume-high-slave');
		muted_slave.classList.add('icon-volume-mute-slave');
	}
}

function mutedMusic_local() {
	if (player.muted) {
		player.muted = false;
		muted_local.classList.remove('icon-volume-mute-local');
		muted_local.classList.add('icon-volume-high-local');
	} else {
		player.muted = true;
		muted_local.classList.remove('icon-volume-high-local');
		muted_local.classList.add('icon-volume-mute-local');
	}
}

function mutedMusic() {
	if (player.muted) {
		player.muted = false;
		muted.classList.remove('icon-volume-mute');
		muted.classList.add('icon-volume-high');
	} else {
		player.muted = true;
		muted.classList.remove('icon-volume-high');
		muted.classList.add('icon-volume-mute');
	}
}


// Time Update
function timeUpdateMusic() {
	durationTime.innerHTML = secondToMinutes(player.duration);
	currentTime.innerHTML = secondToMinutes(player.currentTime);
	seek.max = player.duration;
	if(!seeking)
		seek.value = player.currentTime;
	if(admin_play)
		socket.emit('update currentTime', player.currentTime);
}

// Convert Seconds to Minutes
function secondToMinutes(seconds) {
	if(isNaN(seconds))
		seconds = 0;
	var numMinutes = Math.floor((((seconds % 31536000) % 86400) % 3600) / 60),
			numSeconds = Math.round((((seconds % 3153600) % 86400) % 3600) % 60);

	numMinutes = numMinutes >= 10 ? numMinutes : ('0' + numMinutes);
				
	if (numSeconds >= 10) {
		return numMinutes + ':' + numSeconds;
	} else {
		return numMinutes + ':0' + numSeconds;
	}
}

// Ended Music
function endedMusic() {
	player.pause();
	if(admin_play) {
		$.ajax({
			url: "remove-from-list",
			type: "get",
			data: {"zingid":zingid},
			success: function (response) {
				socket.emit('update list');
				$.ajax("listsong", {			
					success: function(response){
						$(".table-body").html(response);
						if(songNumber>0)
						{
							songNumber--;
							socket.emit('song ended',songNumber);
						}
						if(songNumber != 0) {
							if(admin_play)
								play_song(0);
						}
					}
				});
			}
		});			
	}
	else {
		//play_song(_songindex+1);
	}
}

$(document).ready(function () {

	player = document.getElementById('nowplaying');
	playLoading = document.querySelectorAll('.player__loading span');
	playPause = document.getElementById('playPause');
	btnStop = document.getElementById('btn-stop-admin');
	currentTime = document.getElementById('currentTime');
	seek = document.getElementById('seek');
	durationTime = document.getElementById('durationTime');
	muted_local = document.getElementById('muted-local');
	muted_slave= document.getElementById('muted-slave');
	muted = document.getElementById('muted');
	len = playLoading.length;

	var artistavatar = $('.artist-avatar').children();

	
	playPause.addEventListener('click', playPauseMusic, false);

	muted_slave.addEventListener('click', function(){
		if(isAdmin()&&admin_play)
		{
			socket.emit('mute music');
		}
		
		mutedMusic_slave();
		if($(".icon-volume-mute-slave").length>0 && $(".icon-volume-mute-local").length>0){
			$("#btn-mute").removeClass('icon-volume-high');
			$("#btn-mute").addClass('icon-volume-mute');
		}else {
			$("#btn-mute").addClass('icon-volume-high');
			$("#btn-mute").removeClass('icon-volume-mute');
		}
	});

	muted_local.addEventListener('click', function(){
		
		mutedMusic_local();
		if($(".icon-volume-mute-slave").length>0 && $(".icon-volume-mute-local").length>0){
			$("#btn-mute").removeClass('icon-volume-high');
			$("#btn-mute").addClass('icon-volume-mute');
		}else {
			$("#btn-mute").addClass('icon-volume-high');
			$("#btn-mute").removeClass('icon-volume-mute');
		}
	});

	muted.addEventListener('click', function(){
		mutedMusic();
	});

	player.addEventListener('ended', endedMusic, false);

	btnStop.addEventListener('click', function () {
		if(isAdmin())
			socket.emit('stop music');
		stopMusic();
	}, false);

	seek.addEventListener('mousedown',function() {
		seeking = true;
	});
	seek.addEventListener('mouseup',function() {
		seeking = false;
	});
	
	$('#seek').on('change',seekMusic);


	/*setInterval(function () {
		$.ajax({
			url: "check-time",
			type: "get",
			success: function (response) {
				if(response=="play")
				{
					if($("#nowplaying").prop('paused'))
					{
						socket.emit('play music');
					}
				}
				else if (response=="stop")
				{
					socket.emit('stop music');
				}
			}
		});
	}, 30000);*/

	$("#nowplaying").bind('play', function() {
		user_play=false;
		playing = true;
		audio.trigger("pause");
		audio.parent().removeClass("pause");
		audio.parent().removeClass("playing");
		timeInterval = setInterval(timeUpdateMusic, 500);
		playPause.classList.remove('fa-play');
		playPause.classList.add('fa-pause');
		for (i = 0; i < len; i++) {
			playLoading[i].classList.add('active');
		}

		if($(".list-pausing").length>0) {
			$(".list-pausing").addClass("spiral");
			$(".list-pausing").addClass("list-playing");
		}

		if($(".spiral").length==0) {
			$('.list-song').children().children().first().children('div.e-item').children('div.artist-avatar').children().addClass('spiral');
		}

	});

	$("#nowplaying").bind('pause ended', function() {
		
		playing = false;
		clearInterval(timeInterval);
		playPause.classList.remove('fa-pause');
		playPause.classList.add('fa-play');
		for (i = 0; i < len; i++) {
			playLoading[i].classList.remove('active');
		}
		$('.thumb').removeClass('spiral');
		if($(".playing").length>0) {
			$(".list-playing").addClass("list-pausing");
			$('.list-song').children().children().children('div.e-item').children('div.artist-avatar').children().removeClass('playing');

		}

	});

	$("#ffwd").on('click',function () {
		if(!player.paused || (player.currentTime!=0))
		{
			if(!admin_play) {
				play_song(_songindex+1);
			}
			else if(isAdmin()) {
				socket.emit('fast forward');
				endedMusic();
			}
		}
	});

	$("body").on('click',".e-item",function () {
		if(admin_play==false){
			var index = $(this).parent().index();
			var audio = $("#nowplaying");
			var this_artistavatar = $(this).children('div.artist-avatar').children();
			var artistavatar= $('.artist-avatar').children();
			$('.list-song').children().children().children('div.e-item').children('div.artist-avatar').children().removeClass('list-playing');
			$('.list-song').children().children().children('div.e-item').children('div.artist-avatar').children().removeClass('list-pausing');

			if(audio.prop("paused")) {
				play_song(index);
				artistavatar.removeClass("spiral");
				this_artistavatar.addClass("spiral");	
				this_artistavatar.addClass("list-playing");
			}
			else {
				audio.trigger("pause");
				artistavatar.removeClass("spiral");
				this_artistavatar.addClass("list-pausing");
			}
		}else{
			alert("Music is playing!");
		}
			
	});	
		
	
});


