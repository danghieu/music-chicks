var socket = io('http://localhost:3000');
var appurl = 'http://localhost/music-chicks/music-chicks/public/home';
var tabID;

chrome.tabs.onCreated.addListener(function(tab){
	tabID = tab.id;
});

socket.on('play music',function () {
	chrome.tabs.create({url:appurl});
});

socket.on('stop music',function () {
	chrome.tabs.remove(tabID);
});

// chrome.extension.onMessage.addListener(
//     function(message, sender, sendResponse) {
//         if ( message.type == 'closeMe' )
//         {
//         	chrome.tabs.remove(sender.tab.id);
//         }
//     }
// );