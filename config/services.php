<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/
	'facebook' => [
    'client_id' => env('FB_CLIENT_ID', 'forge'),
    'client_secret' => env('FB_CLIENT_SECRET', 'forge'),
    'redirect' => env('FB_REDIRECT', 'forge'),
	],
	
	'google' => [
    'client_id' => env('GG_CLIENT_ID', 'forge'),
    'client_secret' => env('GG_CLIENT_SECRET', 'forge'),
    'redirect' => env('GG_REDIRECT', 'forge'),
	],
	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'App\User',
		'secret' => '',
	],

];
