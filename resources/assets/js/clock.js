function updateClockview() {
	if($(".clockview").length>0) {
		$.ajax("clockview", {			
			success: function(response){
				$(".clockview").html(response);			
			}
		});
	}
}
$(document).ready(function(){
	updateClockview();
});