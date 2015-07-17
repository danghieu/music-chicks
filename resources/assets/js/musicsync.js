$(document).ready(function () {
	socket.on('info',function (data) {
  		admin_play = data.playing;
    	console.log('admin playing:'+admin_play);
	});

	socket.on('update list', function(){
		updateList();
	});

	socket.on('update countdown', function () {
		updateClockview();
	});
});