var opener = require('openurl'),
io = require('socket.io-client'),
socket = io.connect('http://localhost:3000');

var appurl = 'http://localhost/music-chicks/public/home';

socket.on('connect', function () { console.log("socket connected"); });
//socket.emit('private message', { user: 'me', msg: 'whazzzup?' });

socket.on('play music', function () {
	opener.open(appurl);
	console.log("play music");
});