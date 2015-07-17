<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Zing;
use App\Song;

class SearchController extends Controller {
	public function searchZing(Request $request) {		
		if($request->has('q'))
		{
			$numOfRow = 10;
			$zing = new Zing;
			$zingSongs = $zing->getSearchResult($request->get('q'),$numOfRow);
			$mySongs = array();
			foreach ($zingSongs as $key => $song) {
				if(Song::isExist($song->ID))
				{
					$mysong = Song::getSongByZingid($song->ID);
					if($mysong->inlist)
					{
						array_push($mySongs, $mysong);
						unset($zingSongs[$key]);
					}					
				}
			}
			
			if($request->isMethod('post'))
				return view("search",compact('zingSongs','mySongs'));
			else
				return view("searchfull",compact('zingSongs','mySongs'));
		}
	}

	
}