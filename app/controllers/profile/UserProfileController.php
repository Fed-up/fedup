<?php

class UserProfileController extends BaseController {

	public function getAddUser(){


		// echo '<pre>'; print_r('hi'); echo '</pre>'; 	exit;

		return View::make('profile.signup')
			->with(array('title' => 'Welcome'));
	}

	public function postAddUserHome(){
		
		$input = Input::all();	

		$fname = $input['fname'];
		$email = $input['email'];

		$rules = array(
			'fname' => 'required',
			'email' => 'required|email|unique:users',
		);

		$validator = Validator::make($input, $rules);
		
		if($validator->fails()){

			// get the error messages from the validator
        	$issues = $validator->messages();
        	// echo '<pre>'; print_r($errors); echo '</pre>'; 	exit;

			return View::make('public.index')	
				->withInput($input)
				->withErrors($validator);
				// ->with(array(
				// 	'issue' => $issues,
				// 	)
				// );

		}else{

			$data	= new User();
			//echo '<pre>'; print_r($input); echo '</pre>'; 	exit;
			$data->fname 	= Input::get('fname');
			$data->email 	= Input::get('email');
			$data->fedup = 1;
			$data->user_type 	= 'GUEST';
			$data->active  = 1;	
			$data->save();
			// echo '<pre>'; print_r($data); echo '</pre>'; 	exit;	
		}; 

		$data = User::find($data->id);
		// echo '<pre>'; print_r($data); echo '</pre>'; 	exit;		

		$registered = 'Thankyou for joining us! We look forward to spoiling you with our delicious selection';
		return View::make('profile.signup')
			->with(array(
				'registered' => $registered,
				'data' => $data,
				'title' => 'Welcome',
			)
		);	
	}
	
	public function postAddUser(){
		$input = Input::all();
		// echo '<pre>'; print_r($input); echo '</pre>'; 	exit;

		$rules = array(
			'fname' => 'required',
			'email' => 'required|email|unique:users,email,'.Input::get('id'),
			'password' => 'required|min:6',
			'password_match' => 'required|min:6|same:password',
		);


		
		$validator = Validator::make($input, $rules);
		
		if($validator->fails()){
			return Redirect::back()
				->withErrors($validator)
				->withInput($input);
		}else{

			// echo '<pre>'; print_r($input); echo '</pre>'; 	exit;

			$data	= new User();
			//echo '<pre>'; print_r($input); echo '</pre>'; 	exit;
			$data->fname 	= Input::get('fname');
			$data->email 	= Input::get('email');
			$data->fedup = 1;
			$data->password 	= Hash::make(Input::get('password'));
			$data->user_type 	= 'GUEST';
			$data->active  = 1;	
			$data->save();
			// echo '<pre>'; print_r($data); echo '</pre>'; 	exit;	
		}; 

		$credentials = array(
				'email' =>	Input::get('email'),
				'password' =>	Input::get('password'),
				'active' => 1
			);
		if(Auth::attempt($credentials)){
			//return Redirect::to('admin');
			
			// echo '<pre>'; print_r( Auth::user()->admin); echo '</pre>';exit;
			//exit;
			
			switch (Auth::user()->user_type) {
				case 'ADMIN':
					return Redirect::to('admin');
					break;
				case 'MANAGER':
					return Redirect::to('admin');
					break;
				case 'B2B':
					return Redirect::to('profile');
					break;
				case 'REGISTERED':
					return Redirect::to('profile');
					break;
				case 'GUEST':
					return Redirect::to('profile');
					break;
				default:
					return $this->_doLogout();
			};
			
				
		}else{
			// echo '<pre>'; print_r( Auth::user()); echo '</pre>';exit;
			return Redirect::to('login');	
		}

		//$data = User::all();
		// return Redirect::action('AuthController@postSignUpLogin', array(
		// 	'email' => $data->email, 
		// 	'pw' => $data->password,
		// ));	
		
		// return Redirect::action('ProfileController@getProfile');
		// 	->with(array('data' => $data));
	}

	public function postUpdateAddUser(){
		$input = Input::all();
		$id = Input::get('data_id');
		

		// echo '<pre>'; print_r(); echo '</pre>'; 	exit;
		// echo '<pre>'; print_r($id); echo '</pre>'; 	exit;
		// $id = 7;

		$rules = array(
			'fname' => 'required',
			'email' => 'required|email|unique:users,email,'.$id,
			'password' => 'required|min:6',
			'password_match' => 'required|min:6|same:password',
			
		);

		$validator = Validator::make($input, $rules);

		
		if($validator->fails()){
			return Redirect::back()
				->withErrors($validator)
				->withInput($input);
		}else{


			$user	= User::find($id);
			// echo '<pre>'; print_r($user); echo '</pre>'; 	exit;
			$user->fname 	= Input::get('fname');
			$user->email 	= Input::get('email');
			$user->fedup = 1;
			$user->password 	= Hash::make(Input::get('password'));
			$user->user_type 	= 'GUEST';
			$user->save();
			// echo '<pre>'; print_r($user); echo '</pre>'; 	exit;	
		}; 

		$message = 'Welcome to Selection Cafe Members area, please contact us if you have any enquiries';

		$credentials = array(
				'email' =>	Input::get('email'),
				'password' =>	Input::get('password'),
				'active' => 1
			);
		if(Auth::attempt($credentials)){
			//return Redirect::to('admin');
			
			// echo '<pre>'; print_r( Auth::user()->admin); echo '</pre>';exit;
			//exit;
			
			switch (Auth::user()->user_type) {
				case 'ADMIN':
					return Redirect::to('admin');
					break;
				case 'MANAGER':
					return Redirect::to('admin');
					break;
				case 'B2B':
					return Redirect::to('profile');
					break;
				case 'REGISTERED':
					return Redirect::to('profile');
					break;
				case 'GUEST':
					// return Redirect::to('profile');
					return Redirect::action('ProfileController@getProfile')
						->with(array('message' => $message));	
					break;
				default:
					return $this->_doLogout();
			};
			
				
		}else{
			// echo '<pre>'; print_r( Auth::user()); echo '</pre>';exit;
			return Redirect::to('login');	
		}

		//$data = User::all();	
		return Redirect::action('ProfileController@getProfile')
			->with(array('message' => $message));	
	}

	public function postUpdateUser(){
		$input = Input::all();
		$id = Auth::User()->id;
		
		// echo '<pre>'; print_r($input); echo '</pre>'; 	exit;
		// echo '<pre>'; print_r($id); echo '</pre>'; 	exit;
		// $id = 7;

		if(isset($input->password) || isset($input->password_match)){
			$rules = array(
				'fname' => 'required',
				'email' => 'required|email|unique:users,email,'.$id,
				'password' => 'required|min:6',
				'password_match' => 'required|min:6|same:password',
				
			);
		}else{
			$rules = array(
				'fname' => 'required', 
				'email' => 'required|email|unique:users,email,'.$id,
			);
		}

		$validator = Validator::make($input, $rules);

		
		if($validator->fails()){
			return Redirect::back()
				->withErrors($validator)
				->withInput($input);
		}else{

			// echo '<pre>'; print_r($id); echo '</pre>'; 	exit;

			$user	= User::find($id);
			// echo '<pre>'; print_r($data); echo '</pre>'; 	exit;
			$user->fname 	= Input::get('fname');
			$user->email 	= Input::get('email');
			$user->fedup = 1;
			$user->password 	= Hash::make(Input::get('password'));
			$user->user_type 	= 'GUEST';
			$user->active  = (isset($input['unsubscribe'])) ? 0 : 1;
			$user->save();
			// echo '<pre>'; print_r($data); echo '</pre>'; 	exit;	
		}; 
		if($user->active == 0){
				$message = 'Sorry to know you want to leave.. =('.'<br>'.'If this is a mistake? Quickly change your unsubscription status in your account settings, before you logout =)';
			}else{
				$message = 'Your account information has been updated =)';
			}

		//$data = User::all();	
		return Redirect::action('ProfileController@getProfile')
			->with(array('message' => $message));	
	}















}