<link rel="stylesheet" href="{{Asset('../resources/assets/css/listsong.css')}}"/>
<div class="list-song">
	<ul class="list-group">
	@foreach($songs as $song)
	  <li class="list-group-item col-sm-12 song " data-zingid="{{$song->zing_id}}">
	  
		  	<div class="rank col-sm-1">
		  		@if($song->position<10)
				<span class="txt-rank ">0{{$song->position}}</span>
				@else
				<span class="txt-rank ">{{$song->position}}</span>
				@endif
			</div>

			<div class="e-item col-sm-8 ">
				
				<div class="col-sm-4 artist-avatar"> 
					<img src="{{$song->artistavatar}}" class="thumb circle ">
				</div>	
				<div class="info-song col-sm-8 " >
					<h4>{{$song->title}}</h4>
					<p>{{$song->artist}} </p>
				</div>
				
			</div>
			@if(Session::get("userlevel")!=3)
			<div class="tool-song col-sm-3">
				<div class="voteup col-sm-6">
					<a class="btn-vote btn-voteup" id="{{$song->id}}" href="#">
						<img class="img-voteup" src="{{Asset('../resources/assets/img/btn-voteup.png')}}">
						<img class="img-voteup-hover" src="{{Asset('../resources/assets/img/btn-voteup-hover.png')}}">
					</a>
				</div>
				<div class="votedown col-sm-6">
					<a class="btn-vote btn-votedown" id="{{$song->id}}" href="#">
						<img class="img-votedown" src="{{Asset('../resources/assets/img/btn-votedown.png')}}">
						<img class="img-votedown-hover" src="{{Asset('../resources/assets/img/btn-votedown-hover.png')}}">
					</a>
				</div>
			</div>	
			@endif	
	  </li>
	@endforeach  
	</ul>
</div>

