var ready = false;
var socket = io('http://localhost:3000');
function updateList() {
	if($(".table-body").length>0) {
		$.ajax("listsong", {			
			success: function(response){
				$(".table-body").html(response);			
				if(!ready) {
					ready = true;
					socket.emit('ready');
				}
			}
		});
	}
}

function updateRestVote() {
	if($(".rest-vote").length>0) {
		$.ajax("restvote", {			
			success: function(response){
				$(".rest-vote").html(response);			
				}
			}
		);
	}
}

function updateVotedList() {
	if($(".votedsongs").length>0) {
		$.ajax("voted", {			
			success: function(response){
				$(".votedsongs").html(response);			
				}
			}
		);
	}
}

function fireVote (sender) {
	if(sender.hasClass("btn-voteup"))
	{
		$action = "voteup";
	} 
	else if (sender.hasClass("btn-votedown"))
	{
		$action = "votedown";	
	}
	$.ajax("vote", {
		data:	{"action":$action,"id":sender.attr('id')},		
		success: function(feedback) {
			if(feedback=="success")	{
				socket.emit('update list');
				updateList();
				updateRestVote();
				updateVotedList();
			}
			else
				alert(feedback);
		}
	});
}

$(document).ready(function(){
	updateRestVote()	
	updateList();
	updateVotedList();
	//vote down
	$("body").on('click', '.btn-vote', function(event){
		event.preventDefault();
		if(admin_play == false){
			var sender = $(this);
			$.ajax('check-time', {
				success: function (response) {
					//alert(response.time);
					if(response.endofday)
						alert('time is up');
					else
						fireVote(sender);
				}
			});
		} else
			alert("Music is playing!");
		
	});
	


	
});
