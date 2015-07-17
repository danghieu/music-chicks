<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use App\User;
use App\Zing;

class Song extends Model {
	public $table = "songs";
	public function votes()
    {
        return $this->belongsToMany('App\User','votes')->withTimestamps();;
    }

	public static function getListSongPosition(){
		return Song::where("inlist",1)->orderBy('position', 'ASC')->get();
	}

	public static function Isvoted($id){
		$user = User::find(Session::get("userid"));
		$today = new \DateTime('today',new \DateTimeZone('Asia/Ho_Chi_Minh'));
		/*foreach ($user->votes as $song ) {
			if($song->id==$id) return true;
		}*/
		$count = DB::table('votes')->where('created_at','>=', $today)->where('user_id',$user->id)->where('song_id',$id)->count();
		if($count>0)
			return true;
		return false;		
	}

	public static function votedown($id){
		
			//get position of the song has $id
			$position = Song::getPosition($id);
			//get id of the sang has position +1
			$position2=$position+1;
			$id2 = Song::getIdSongPosition($position2);
			//increase position of the song has $id
			Song::IncreasePosition($id);
			//decrease position of the song has $id2
			Song::DecreasePosition($id2);

			//
			$user = User::find(Session::get("userid"));
			$user->votes()->attach($id,['action' => 'votedown']);



	}

	public static function voteup($id){
			//get position of the song has $id
			$position = Song::getPosition($id);
			//get id of the sang has position +1
			$position2=$position-1;
			$id2 = Song::getIdSongPosition($position2);
			//increase position of the song has $id
			Song::DecreasePosition($id);
			//decrease position of the song has $id2
			Song::IncreasePosition($id2);

			//
			$user = User::find(Session::get("userid"));
			$user->votes()->attach($id,['action' => 'voteup']);

	}


	public static function getIdSongPosition($position){
		
		$song=DB::table('songs')->where('position', $position)->where('inlist',1)->first();
		return $song->id;
	}

	public static function IncreasePosition($id){
		$position=Song::getPosition($id);
		$position=$position+1;
		DB::table('songs')
            ->where('id', $id)
            ->update(['position' => $position]);
	}

	public static function DecreasePosition($id){
		$position=Song::getPosition($id);
		$position=$position-1;
		DB::table('songs')
            ->where('id', $id)
            ->update(['position' => $position]);
	}

	public static function getPosition($id){
		$song=DB::table('songs')->where('id', $id)->first();
		return (int)$song->position;
	}

	public static function isExist($zingID)
	{
		if(Song::where("zing_id","=",$zingID)->count() > 0)
			return true;
		return false;
	}

	public static function getSongByZingid($zingID)
	{
		$query = Song::where("zing_id",$zingID);
		if($query->count()>0)
			return $query->first();
		else
			return null;
	}

	public static function getLowestPosition()
	{
		return Song::where('inlist',1)->count() + 1;
	}

	public static function updatePosition()
	{
		$listsong = Song::getListSongPosition();
		$index = 1;
		foreach ($listsong as $song) {
			$song->position = $index;
			$song->save();
			$index++;
		}
	}

	public function getLink()
	{
		$zing = new Zing;
		$songDetail = $zing->getSongDetail($this->zing_id);
		if(isset($songDetail->LinkPlay128))
		{
			return $songDetail->LinkPlay128;
		}
		return "";
	}
}
