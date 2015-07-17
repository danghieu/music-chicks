<h4 align="center">Songs you've voted</h4>
<ul class="list-group col-sm-12">
	@foreach($songs as $song)
	  <li class="list-group-item col-sm-12 song" data-zingid="{{$song->zing_id}}">
	  
		  	<div class="col-sm-1">
				<span class="voted-index "></span>
			</div>
			<div class="e-item col-sm-11">
					
				<div class="info-song col-sm-12 " >
					<h4>{{$song->title}}</h4>
					<p>{{$song->artist}} </p>
				</div>		
			</div>	
	  </li>
	@endforeach  
</ul>