var audio=$('audio');
function updateSearchList() {
	if($("#search-result").length>0) {
		$.ajax("search", {
				type: "post",
				data: {"q":$("#q").val()},
				success: function(response){
					$("#search-result").html(response);
				}
		});
	}
}

$(document).ready(function(){

	$("#q").keyup(function() {
			updateSearchList();
		});

	$("#q").on('focus', function () {
		$("#search-result").fadeIn('fast');
	});

	$("body").on('click', '.song-item-content', function()
	{
		var parent = $(this).parent();
		audio = parent.children('audio');	
		if(playing == false){
					
			if(audio.prop("paused")) {
				var other_items = parent.siblings();
				var other_audios = other_items.children('audio');

				other_audios.trigger('pause');
				other_audios.prop("currentTime",0);
				audio.trigger("play");

				parent.removeClass("pause");
				parent.addClass("playing");
				other_items.removeClass("pause");
				other_items.removeClass("playing");
			}
			else {
				audio.trigger("pause");
				parent.removeClass("playing");
				parent.addClass("pause");
			}
		}else{
			alert("Music is playing!");
		}
	});

	$("body").on('click', '.btn-add', function(event)
	{
		event.preventDefault();
		var song_item = $(this).parent();		
		$.ajax('addsong',{
			type:'get',
			data: {'zingid':$(this).data('id')},
			success: function(response){
				if(response == 'success')
				{
					song_item.html('<div class="add-msg"><span>this song is added successfully</span></div>');
					setTimeout(function () {
						song_item.fadeOut();
					},1000);
					socket.emit('update list');
					updateList();
					updateSearchList();
				}
				else
					alert("Failed to add this song");
			},
			error: function() {
				alert("Failed to add this song");	
			}
		});
	});
	
	$("body").on("click", function (event) {
		if(!$(event.target).closest('.search').length)
		{
			if($('#search-result').is(":visible")) {
            	$('#search-result').fadeOut('fast');
        	}
		}
	});
});