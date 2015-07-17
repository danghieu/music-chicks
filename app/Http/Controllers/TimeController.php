<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TimeToPlay;
use DB;

class TimeController extends Controller {
	public function setTime(Request $input)
	{
		if($input->has('from')) {
			$time = null;
			if($input->has('timeid'))
			{
				$time = TimeToPlay::getTimeById($input->get('timeid'));
				if($time == null)
					return "failed";
			}
			else
				$time = new TimeToPlay;
			$time->from = $input->get('from');
			$time->number=$input->get('number');
			
			$time->save();
			return "success";
		}
	}

	public function removetime(Request $input)
	{
		if(DB::table('time_to_play')->count()>1){
			if($input->has('timeid')) {
				$time = TimeToPlay::getTimeById($input->get('timeid'));
				if($time != null)
				{
					$time->delete();
					return "success";
				}
			}
		}else
			return "failed";
		
	}

	public function settimelist()
	{
		$timetoplay = TimeToPlay::all();
		return view('settime',compact('timetoplay'));
	}

	public function checkTime()
	{
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		$now = date("H:i:00");
		if($now > TimeToPlay::getEndtime())
			return response()->json(['time' => $now, 'endofday' => true]);
		$times = DB::table('time_to_play')->orderBy('from','ASC')->get();

		foreach ($times as $time) {
			if($time->from == $now)
				return response()->json(['time' => $now, 'play' => true, 'number' => $time->number]);;
		}		
		return response()->json(['time' => $now]);
	}
	public function clockview(){
		$endtime = TimeToPlay::getEndtime();
		return view('clockview',compact('endtime'));
	}
}