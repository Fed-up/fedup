<?php

class HomeController extends BaseController {

	public function getIndex(){


	// CLIENT INFO
	// CLIENT ID	94698d5b9b00463481a789a88fd89195
	// CLIENT SECRET	af946a514b9840d898d0970677174f81
	// WEBSITE URL	http://www.selectioncafe.com.au
	// REDIRECT URI	http://www.selectioncafe.com.au
	// SUPPORT EMAIL	social@selectioncafe.com.au

		$token = "94698d5b9b00463481a789a88fd89195";
		$client_id ="dbc68a32a245496a85281256639e2ee3";
		$insta_url = 'https://api.instagram.com/v1/tags/sonaughtybutnice/media/recent?client_id='.$token.'&count=12';

		$insta_url = 'https://api.instagram.com/v1/users/self/feed?client_id='.$token.'&count=12';
		$insta_url = 'https://api.instagram.com/v1/users/592534639/media/recent/?client_id='.$client_id.'&count=12';

		// $insta_json = file_get_contents($insta_url);
		// $insta_array = json_decode($insta_json, $true);

		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$insta_url);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);

		// Will dump a beauty json :3
		$insta_array = json_decode($result, true);
		// foreach($insta_array['data'] as $image){
		// 	echo '<pre>'; print_r($image['images']['low_resolution']['url']); echo '</pre>'; 	
		// }
		// echo '<pre>'; print_r($insta_array); echo '</pre>'; exit;	
		// exit;
		// if(empty($insta_array)){
		// 	echo '<pre>'; print_r($token); echo '</pre>'; exit;	
		// }
		

		return View::make('public.index')
		->with(array(
			'home' => 'home',
			'insta_array' => $insta_array 
		));
	}

	public function getAbout(){
		return View::make('public.about');
	}

	public function getMaps(){

	// // I'm creating an array with user's info but most likely you can use $user->email or pass $user object to closure later
	// $user = array(
	// 	'email'=>'tomcurphey12@gmail.com',
	// 	'name'=>'Tom'
	// );

	// // the data that will be passed into the mail view blade template
	// $data = array(
	// 	'detail'=>'You are awesome',
	// 	'name'=>'Samhj'
	// );

	//  echo '<pre>'; print_r($user['email']); echo '</pre>';exit;

	// // use Mail::send function to send email passing the data and using the $user variable in the closure
	// Mail::send('public.maps', $data, function($message) use ($user)
	// {
	//   $message->from('hello@sonaughtybutnice.com', 'Sarah and Tom');

	//   $message->to('tomcurphey12@gmail.com', 'Tom')->subject('Welcome to My Laravel app!');
	// });


	 Mail::send('public.maps', array('name' => 'Tom'), function($message){
		$message->to('hello@sonaughtybutnice.com', 'Tom Curphey')->subject('test email');
	}); 

	// echo '<pre>'; print_r($ingredient_image); echo '</pre>';
	// echo '<pre>'; print_r($iData); echo '</pre>';
	// exit;

	return View::make('public.maps');
		// ->with(array(
		// 'detail' => $detail, 
		// 'name' => $name,
		// ));
	

	}

}