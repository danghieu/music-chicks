<?php namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class TimeToPlay extends Model {
	public $table = "time_to_play";
	public $timestamps = false;
	public static function getTimeById($id)
	{
		$result = TimeToPlay::where('id',$id);
		if($result->count()>0)
			return $result->first();
		return null;
	}

	public static function getEndtime(){
	
		$endtime=TimeToPlay::select('from')->where('id','=',1)->first()->from;
		return $endtime;
		
	}
}
