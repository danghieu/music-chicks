$(document).ready(function () {
	socket.on('stop music', function(){
		stopMusic();
		//admin_play = false;
		songNumber = -1;
	});
/*
	socket.on('get currentTime', function(){
		if(!player.paused)
			socket.emit('get currentTime',player.currentTime);
	});
*/
	socket.on('change currentTime', function(curTime){
		if(!isAdmin() || playing) {
			seek.value = curTime;
			$('#seek').trigger('change');
		}
	});

	socket.on('info',function (data) {
  		admin_play = data.playing;
  		songNumber = data.numberOfSongs;
    	console.log('admin playing:'+admin_play+', songNumber:'+songNumber);
	})
});