$(document).ready(function () {
	socket.on('play music', function(data){
		console.log('I have to play music');
		if(player.paused)
		{

			adminPlay(!data.paused);
			//player.currentTime = data.curTime;
			
			if(player.muted != data.muted)
				mutedMusic_local();
		}
	});

	socket.on('mute music', function(mute){
		if(player.muted != mute)
			mutedMusic_local();
	});

	socket.on('pause music', function(){
		player.pause();
	});

	socket.on('unpause music', function(){
		player.play();
	});

	socket.on('fast forward', function(){
		endedMusic();
	});

	// socket.on('stop music',function () {
	// 	window.opener=self;
	// 	window.top.close();
	// 	window.open('','_self').close();
	// 	chrome.extension.sendMessage({ type: 'closeMe' });
	// })
});