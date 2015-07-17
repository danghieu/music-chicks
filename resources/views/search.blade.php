
<ul class="list-group col-sm-12" style="padding-right: 0;">
	@if($mySongs!=null)
	@foreach($mySongs as $song)
	<li class="list-group-item">
		<div class="playing_icon"></div>
		
		<div class="song-item-content ">
			<h4 class="list-group-item-heading">{{$song->title}}</h4>
  			<p class="list-group-item-text">{{$song->artist}}</p>      	      		
  		</div>

		<audio preload="none" ><source src="{{$song->getLink()}}" type="audio/mpeg"></audio>
		@if(Session::get("userlevel")!=3)
		<div class="tool-song tool-song-small">
			<div class="votedown-small float-right">
				<a class="btn-vote btn-votedown  btn-vote-small" id="{{$song->id}}" href="#">
					<img class="img-votedown" src="{{Asset('../resources/assets/img/btn-votedown.png')}}">
					<img class="img-votedown-hover" src="{{Asset('../resources/assets/img/btn-votedown-hover.png')}}">
				</a>
			</div>
			<div class="voteup-small float-right">
				<a class="  btn-vote btn-voteup btn-vote-small" id="{{$song->id}}" href="#">
					<img class="img-voteup" src="{{Asset('../resources/assets/img/btn-voteup.png')}}">
					<img class="img-voteup-hover" src="{{Asset('../resources/assets/img/btn-voteup-hover.png')}}">
				</a>
			</div>
			
		</div>
		@endif
	</li>
	@endforeach
	@endif
	@if($zingSongs!=null)
	@foreach($zingSongs as $song)
	<li class="list-group-item">
		<div class="playing_icon"></div>
		<a class="btn btn-sm btn-add btn-a-bg float-right" data-id="{{$song->ID}}" href="#">Add</a>
		<div class="song-item-content">
			<h4 class="list-group-item-heading">{{$song->Title}}</h4>
  			<p class="list-group-item-text">{{$song->Artist}}</p>      	      		
  		</div>
		<audio preload="none" ><source src="{{$song->LinkPlay128}}" type="audio/mpeg"></audio>
	</li>
	@endforeach
	@endif
</ul>