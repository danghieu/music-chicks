<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Song;
use Illuminate\Http\Request;
use App\Zing;
use Session;
use App\User;

class SongController extends Controller {

	public function test() {
		
		$user = User::find(Session::get("userid"));
		$a= 'fasle';
		foreach ($user->votes as $song ) {
			if($song->id==2) $a= 'true';
		}
		
		
		return view('test',compact('restvotes','a'));
	}

	function songlist(Request $input)
	{
		$songs= Song::getListSongPosition();
		return view('listsong',compact('songs'));
	}

	function vote(Request $input)
	{
		if($input->has('action')&&$input->has('id')){
			$user = User::find(Session::get("userid"));
			$songid=$input->get('id');
			if($user->votes->count()>=5)
				return "You have no vote today.";
			if(Song::Isvoted($songid))
				return "This song was voted.";
			if($input->get('action')=='voteup')
			{
				if(Song::getPosition($songid)==1)
					return "This song is on top.";
				Song::voteup($songid);
				return "success";
			}
			if($input->get('action')=='votedown')
			{
				if(Song::getPosition($songid)==(Song::getLowestPosition()-1))
					return "This song is on bottom.";
				Song::votedown($songid);
				return "success";
			}
						
			return "Oops, something wrong!";	
		}				
	}

	/*
	function listsong(Request $input){
		$songs= Song::getListSongPosition();
		$errors = array();
		if($input->has('action')&&$input->has('id')){
			$songid=$input->get('id');
			if($input->get('action')=='voteup'){

				if(Song::restVotes()>0 ){
					if(!Song::Isvoted($songid)){
						if(Song::getPosition($songid)!=1){
							Song::voteup($songid);
							}else {
								$errors[]="This song is on top.";
							}
							
						
					}else $errors[]="This song was voted.";
				}else $errors[]="You have no vote today.";

				$songs= Song::getListSongPosition();
				return view('listsong',compact('songs','errors'));	
				
					
			}else if ($input->get('action')=='votedown'){

				if(Song::restVotes()>0 ){
					if(!Song::Isvoted($songid)){

						if(Song::getPosition($songid)< (Song::getLowestPosition()-1)){
							Song::votedown($songid);
							}else {
								$errors[]="This song is on bottom.";
							}
					}
					else $errors[]="This song was voted.";
				}else $errors[]="You have no vote today.";

				$songs= Song::getListSongPosition();
				return view('listsong',compact('songs','errors'));
			}

		}else return view('listsong',compact('songs'));
	}*/

	public function addsong(Request $input)
	{
		if($input->has('zingid'))
		{
			$zingid = $input->get('zingid');
			$song = Song::getSongByZingid($zingid);
			if($song != null)
			{
				if($song->inlist)
					return "failed";
				else
				{
					$song->inlist = true;
					$song->position = Song::getLowestPosition();
					$song->user_id = Session::get('userid');
					$song->save();
					return "success";
				}
			}
			$zing = new Zing;
			$songDetail = $zing->getSongDetail($zingid);
			if(isset($songDetail->ID))
			{
				$song = new Song;
				$song->title = $songDetail->Title;
				$song->artist = $songDetail->Artist;
				$song->zing_id = $zingid;
				if($songDetail->ArtistDetail != null) {
					$artistDetail = (array) $songDetail->ArtistDetail;
					$song->artistavatar = array_shift($artistDetail)->ArtistAvatar;
				}
				else {
					$song->artistavatar = "http://static.mp3.zing.vn/skins/mp3_v3_16/images/avatar_default_82x82.jpg";	
				}
				$song->position = Song::getLowestPosition();
				$song->user_id = Session::get('userid');
				$song->save();
				return "success";
			}
		}
		return "failed";
	}

	public function getlink(Request $input)
	{
		if($input->has('zingid'))
		{
			$zingid = $input->get('zingid');
			
			$zing = new Zing;
			$songDetail = $zing->getSongDetail($zingid);
			if(isset($songDetail->LinkPlay128))
			{
				return $songDetail->LinkPlay128;
			}
		}
		return "failed";
	}

	public function removeFromList(Request $input)
	{
		if($input->has('zingid'))
		{
			$zingid = $input->get('zingid');
			$query = Song::where("zing_id","=",$zingid);
			if($query->count()>0)
			{
				$song = $query->first();
				$song->inlist = false;
				$song->playedtimes += 1;
				$song->save();
				Song::updatePosition();
			}			
		}
	}

}
