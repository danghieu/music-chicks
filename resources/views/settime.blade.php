<h4 style="text-align:center;">Time to play</h4>
<ul class="list-group time-to-play col-sm-12">
			@foreach($timetoplay as $time)
			@if($time->id==1)
			<li class="list-group-item end-of-date time-item col-sm-12" data-timeid="{{$time->id}}">
			@else
			<li class="list-group-item time-item col-sm-12" data-timeid="{{$time->id}}">
			@endif
				<div class="time-display col-sm-offset-2 col-sm-8">
					<time class="time-from" datetime="{{$time->from}}">{{$time->from}}</time>
					-
					@if($time->number==1)
					 <span class="time-number" datetime="{{$time->number}}">{{$time->number}} </span>song
					 @else
					<span class="time-number" datetime="{{$time->number}}">{{$time->number}} </span>songs

					@endif
				</div>

				<div class="time-input col-sm-10" style="display:none;">	

						<input type="time" name="from" class="time-from"> - 
						<input type="number" name="number" class="time-number" min="1" max="99" value="{{$time->number}}">
						
				</div>
				
				<div  class="set-time-tool">
						<button class="time-save fa fa-save floatleft " style="display:none;"></button>
					
						<button type="button" class="time-edit  fa fa-pencil floatleft" ></button>
					
						@if($time->id!=1)
						<button type="button" class="time-delete  fa fa-close floatleft"></button>
						@endif				
					
				</div>
						
			</li>
			@endforeach
			<li class="list-group-item time-item col-sm-12 add-time" style="display:none;" >
				<div class="time-input col-sm-10" >	

						<input type="time" name="from" value="17:00" class="time-from"> - 
						<input type="number" name="number" class="time-number" min="1" max="99" value="1">

				</div>
				<div  class="set-time-tool ">
						<button class="time-save fa fa-save add-save " ></button>							
				</div>	
					
			</li>
		</ul> <!-- list-group -->
		<button class="btn btn-add-time btn-bg">Add</button>