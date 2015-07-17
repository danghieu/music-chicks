var app = require('express')();
var http = require('http')
var server = http.Server(app);
var io = require('socket.io')(server);

var checkTimeURL = {
  host: 'localhost',
  port: 80,
  path: '/music-chicks/music-chicks/public/check-time'
};

var playing = false;
var pausing = false;
var mute = false;
var currentTime = 0;
var numberOfSongs = -1;

var connectionCount = 0;
var waiting = true;

function play_music (socket) {
    playing = true;
    if(socket==undefined)
      socket = io;
    socket.emit('play music',{paused:pausing, muted:mute});
    info(socket);
}

function stop_music(){
  playing = false;
  pausing = false;
  console.log('music is stopped');
  currentTime = 0;
  numberOfSongs=-1;
  io.emit('stop music');
  info(io);
}

function info (socket) {
  var data = {
    playing:playing, 
    pausing:pausing, 
    mute:mute, 
    numberOfSongs:numberOfSongs
  };
  socket.emit('info',data);
  socket.emit('change currentTime',currentTime);
}

var lastCheck = new Date();
lastCheck.setHours(lastCheck.getHours() - 1);

setInterval(function () {
  var now = new Date();
  if((lastCheck.getMinutes() != now.getMinutes()) || (now - lastCheck >= 100000)) {
    lastCheck = now; 
    http.get(checkTimeURL, function(res) {
      res.on('data', function( data ) {
        var instruction = JSON.parse(data);
        //console.log(instruction.time);
        if(instruction.play) {
          console.log('play '+instruction.number+' songs');
          numberOfSongs = instruction.number;
          if(!playing)
            play_music();
        }
      } );
    }).on('error', function(e) {
      console.log("Got error: " + e.message);
    });  
  }
  //console.log('currentTime: '+currentTime);
},1000);
  
server.listen(3000, function(){
  console.log('listening on port 3000');
});

io.on('connection', function(socket){
  connectionCount++;

  socket.on('ready',function () {
    if(playing)
    {
      //waiting = true;
      //socket.broadcast.emit('get currentTime');
      play_music(socket);
    }
    else
      info(socket);
  });

  socket.on('update list', function(){
    socket.broadcast.emit('update list');
  });

  socket.on('update timelist', function(){
    socket.broadcast.emit('update timelist');
  });

  /*socket.on('get currentTime',function (curTime) {
    if(waiting) {
      waiting = false;
      currentTime = curTime;
      info(socket.broadcast);
      socket.broadcast.emit('change currentTime',curTime);
    }     
  });*/

  socket.on('play music', function () {
    if(playing){
      
      console.log('play again');
      /*
      waiting = true;
      socket.broadcast.emit('get currentTime');
      */
      play_music(socket);
      io.emit('unpause music');
    } else {
      console.log('music is played');
      play_music();
    }
  });

  socket.on('stop music', stop_music);

  socket.on('pause music', function(){
    pausing = true;
    console.log('music is paused');
    socket.broadcast.emit('pause music');
  });

  socket.on('unpause music', function(){
    pausing = false;
    console.log('music is unpaused');
    socket.broadcast.emit('unpause music');
  });

  socket.on('mute music', function(){  
    if(!mute) {
      mute = true;
      console.log('music is muted');
      socket.broadcast.emit('mute music',mute);
    }
    else {
      mute = false;
      console.log('music is unmuted');
      socket.broadcast.emit('mute music',mute);
    }
  });

  socket.on('change currentTime', function(curTime){    
    socket.broadcast.emit('change currentTime',curTime);
  });

  socket.on('fast forward', function(){    
    socket.broadcast.emit('fast forward');
  });

  socket.on('song ended', function(songNumber){    
    if(numberOfSongs > songNumber)
      numberOfSongs = songNumber;
    if(numberOfSongs <= 0)
      stop_music();
  });

  socket.on('info', function () {
    info(socket);
  });

  socket.on('update currentTime', function (curTime) {
    if(playing)
    {
        currentTime = curTime;
    }
  });

  socket.on('update countdown', function () {
    socket.emit('update countdown');
  });

  socket.on('disconnect', function(){
    connectionCount--;
    if(connectionCount <= 0)
    {
      stop_music();
    }
  });
});