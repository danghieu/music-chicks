<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Password extends Model {

	public $table = "password_resets";

	public function user()
    {
        return $this->belongsTo('App\User');
    }



	public static function check_token($token) {
		if(Password::where("token","=",$token)->count()>0)
			return true;
		return false;
	}

}
