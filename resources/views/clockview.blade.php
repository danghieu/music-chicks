<link rel="stylesheet" href="{{Asset('../resources/assets/css/dscountdown.css')}}"/>
<script type="text/javascript" src="{{Asset('../resources/assets/js/dscountdown.js')}}"></script>

<script>
	
	var time =" {{$endtime}}";
	
			var today = new Date();
		            var dd = today.getDate();
		            var mm = today.getMonth()+1; //January is 0!
		            var yyyy = today.getFullYear();

		            if(dd<10) {
		                dd='0'+dd
		            } 

		            if(mm<10) {
		                mm='0'+mm
		            } 

		            today = mm+' '+dd+','+yyyy;
		           
			jQuery(document).ready(function($){
				
				$('.clock').dsCountDown({					
					endDate: new Date(mm+' '+dd+","+yyyy+  time)
									});		
						
			});
</script>
<div class=" clock"></div>
