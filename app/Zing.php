<?php namespace App;
class Zing {
	public $publicKey="c1e9642938bee8f03f489b09455ba759950f5f9c";
	public $privateKey='30ad0ae0e22ddc1736698bfb4bee9258'; 

	public function getSearchResult($keyword, &$numOfRow) {		
		$data = array(
				'kw'=>$keyword, 
				't'=>"1", 
				'rc'=> $numOfRow, 
				'p'=>1
				);

		$jsondata =  urlencode(base64_encode(json_encode($data)));
		$signature=hash_hmac('md5',$jsondata , $this->privateKey);
		$apiURL="http://api.mp3.zing.vn/api/search?publicKey=".$this->publicKey."&signature=".$signature."&jsondata=".$jsondata;
		
		$jsonResult = file_get_contents($apiURL);
		//echo $jsonResult;
		$result = json_decode($jsonResult);
		if($numOfRow > $result->ResultCount)
			$numOfRow = $result->ResultCount;
		if($numOfRow>0)
			return $result->Data;
		return null;
	}

	public function getSongDetail($zingID)
	{
		$data = array(
				't'=>"song", 
				'id'=> $zingID
				);

		$jsondata =  urlencode(base64_encode(json_encode($data)));
		$signature=hash_hmac('md5',$jsondata , $this->privateKey);
		$apiURL="http://api.mp3.zing.vn/api/detail?publicKey=".$this->publicKey."&signature=".$signature."&jsondata=".$jsondata;
		
		$jsonResult = file_get_contents($apiURL);
		//echo $jsonResult;
		return json_decode($jsonResult);
	}

	/*public function searchZing2(Request $request) {	
		if($request->has('q'))
		{
			$keyword = urlencode($request->get('q'));
			$length = 5;
			$start = 0;
			$url = 'http://api.mp3.zing.vn/api/mobile/search/song?requestdata={"length":'.$length.',"start":'.$start.',"q":"'.$keyword.'","sort":"hot"}&keycode=b319bd16be6d049fdb66c0752298ca30&fromvn=true';
			$json_data = file_get_contents($url);
			$data = json_decode($json_data);
			return json_encode($data->docs);
		}
	}*/
}