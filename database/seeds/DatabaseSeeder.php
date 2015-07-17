<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\TimeToPlay;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
		User::create(array(
			'name' => 'super',
			'email' => 'superadmin@admin.com',
			'password' => md5(sha1('admin')),
			'level' => 0
		));
		User::create(array(
			'name' => 'slave',
			'email' => 'slave@slave.com',
			'password' => md5(sha1('slave')),
			'level' => 3
		));
		
		TimeToPlay::create(array(
			'from' => '17:00'
		));
	}

}
