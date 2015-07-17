function updateTimeList() {
	if($(".settime").length>0) {
		$.ajax("settimelist", {			
			success: function(response){
				$(".settime").html(response);			
				}
			}
		);
	}
}

$(document).ready(function () {
	updateTimeList();
	$("body").on('click', '.time-edit', function()
	{	
		var time_display = $(this).parent().siblings('.time-display');
		var time_input = $(this).parent().siblings('.time-input');
		$('.time-save').hide();
		$('.time-edit').show();
		$(this).hide();
		$(this).siblings('.time-save').show();
		if($('.time-input').is(":visible")) {
            	$('.time-input').hide();
            	$('.time-display').show();
        }
        $('.add-time').hide();
		time_display.hide();
		time_input.show();

		time_input.children(".time-from").attr('value',time_display.children('.time-from').attr('datetime'));
		time_input.children(".time-to").attr('value',time_display.children('.time-to').attr('datetime'));
		time_input.children(".time-from").focus();
	});

	$("body").on('click', '.time-save', function(event)
	{
		var time_from = $(this).parent().siblings('div.time-input').children('.time-from').val();
		var time_number = $(this).parent().siblings('div.time-input').children('.time-number').val();
		var time_id = $(this).parent().parent().data('timeid');
		var self=$(this);
		$(this).hide();
		$(this).siblings('.time-edit').show();
		$.ajax({
			url: "settime",
			type: "get",
			data: {"from":time_from, "number":time_number, "timeid":time_id},
			success: function (response) {
				if(response=="success")
				{	
					socket.emit('update timelist');
					updateTimeList();
					if($(event.target).closest('.end-of-date').length)
						socket.emit('update countdown');
				}
				else
				{
					alert("failed");
				}
			},
			error: function () {
				alert("failed");
			}
		});
		
	});

	$("body").on('click', '.time-delete', function()
	{
		var time_id = $(this).parent().parent().data('timeid');
		var container = $(this).parent().parent();
		$('.add-time').hide();
		$.ajax({
			url:"remove-time",
			type:"get",
			data:{"timeid":time_id},
			success: function(response){
				if(response=="success")
				{
					container.slideUp('slow', function() {container.remove();});
					socket.emit('update timelist');
					updateTimeList();
				}
				else
				{
					alert("failed");
				}
				
				
			},error:function(){
				alert("failed");
			}


		});
	});

	$("body").on('click', '.btn-add-time', function()
	{
		$('.time-save').hide();
		$('.time-edit').show();
		
		$('.add-save').show();

		$('.time-input').hide();
        $('.time-display').show();
		var addtime = $(this).siblings('.time-to-play').children('.add-time');
		var input = addtime.children('.time-input');
		addtime.show();
		input.show();
		
	});

	$("body").on("click", function (event) {
		if(!$(event.target).closest('.time-to-play').length && !$(event.target).closest('.btn-add-time').length)
		{
			if($('.time-input').is(":visible")) {
				$('.add-time').hide();
            	$('.time-input').hide();
            	$('.time-display').show();
            	$('.time-save').hide();
            	$('.time-edit').show();
        	}
		}
	});

	socket.on('update timelist', function(){
		updateTimeList();
	});
});