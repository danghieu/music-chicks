<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Session;

class User extends Model{
	public $table = "users";
	
	public function votes()
    {
    	$today = new \DateTime('today',new \DateTimeZone('Asia/Ho_Chi_Minh'));
		\DB::table('votes')->where('created_at','<', $today)->delete();
        return $this->belongsToMany('App\Song','votes')->withTimestamps();
    }

    public static function getUserById($id)
    {
    	$users = User::where('id',$id);
    	if($users->count()>0)
    		return $users->first();
    	else
    		return null;
    }

    public static function getUserByRememberToken($token)
    {
    	$users = User::where('remember_token',$token);
    	if($users->count()>0)
    		return $users->first();
    	else
    		return null;
    }

    public function saveSocialUser($user){
		$this->email = $user->getEmail();
    	$this->name = $user->getName();
    	$this->social_id = $user->getId();
    	$this->avatar=$user->getAvatar();
    	$this->save();
	}
    
	public static function check_valid($username_email, $password) {
		$array1 = array('username_email' => $username_email );
		$rules = array('username_email' => "email" );
		if(Validator::make($array1,$rules)->fails())
		{
			$check=User::where("name","=",$username_email)->where("password","=",$password)->count();			
		}
		else
		{
			$check=User::where("email","=",$username_email)->where("password","=",$password)->count();				
		}

		if($check>0)
			return true;
		else
			return false;
	}

	public static function getId($username_email_idsocial) {		
		$users=User::where("name","=",$username_email_idsocial);
		if($users->count()>0)	{
			$user = $users->firstOrFail();
			return $user->id;
		}

		$users=User::where("email","=",$username_email_idsocial);	
		if($users->count()>0)	{
			$user = $users->firstOrFail();
			return $user->id;
		}			
		$users=User::where("token","=",$username_email_idsocial);
		if($users->count()>0)	{
			$user = $users->firstOrFail();
			return $user->id;
		}
		
	}
	public static function username_exist($username) {
		if(User::where("name","=",$username)->count()>0)
			return true;
		return false;
	}

	public static function email_exist($email) {
		if(User::where("email","=",$email)->count()>0)
			return true;
		return false;
	}

	public static function social_id_exist($social_id) {
		if(User::where("social_id","=",$social_id)->count()>0)
			return true;
		return false;
	}

/*
	public static function countVote(){
		$user = User::find(Session::get("userid"));
		
		//$today = new \DateTime('today',new \DateTimeZone('Asia/Ho_Chi_Minh'));
		//return \DB::table('votes')->where('user_id',$user->id)->where('created_at','>=', $today)->count();
		
		return $user->votes->count();
	}

	public static function restVotes(){		
		return User::$numVote - User::countVote();
	}	
*/
	public static function getAvatarbyId($userid){
		$avatar=User::select('avatar')->where('id',$userid)->first()->avatar;
		if($avatar=="") $avatar = asset('../resources/assets/img/no_avatar.jpg');
		return $avatar;
	}
	public static function getNamebyId($userid){
		$name=User::select('name')->where('id',$userid)->first()->name;
		if($name=="") $name = "User";
		return $name;
	}

	public static function getLevelbyemail($email){
		$level=User::select('level')->where('email',$email)->first()->level;
		return $level;
	}

	public static function getLevelbyId($userid){
		$level=User::select('level')->where('id',$userid)->first()->level;
		return $level;
	}

	public static function getStatusbyId($id){
		$status=User::select('active')->where('id',$id)->first()->active;
		return $status;
	}

	public static function check_token($token) {
		if(User::where("remember_token","=",$token)->count()>0)
			return true;
		return false;

	}

	public static function update_name($name,$userid){
			$user = User::where('id',"=",$userid)->update(['name' =>  $name]);		 
	}

	public static function update_email($email,$userid){
		$user = User::where('id',"=",$userid)->update(['email' =>  $email]);		 
	}

	public static function update_password($new,$userid){
		if ($new!="") {
			$user = User::where('id',"=",$userid)->update(['password' =>  md5(sha1($new))]);

		}
	}

	public static function updatestatus($userid)
	{
		if(User::getStatusbyId($userid)==1) {
			User::where('id',"=",$userid)->update(['active' =>  0]);
		}else 
			User::where('id',"=",$userid)->update(['active' =>  1]);
	}
	public static function updatelevel($userid,$role)
	{
		if($role=="admin") $level=1;
		else if($role=="user") $level=2;
		else if($role=="slave") $level=3;
		User::where('id',"=",$userid)->update(['level' =>  $level]);
		
	}
}
?>