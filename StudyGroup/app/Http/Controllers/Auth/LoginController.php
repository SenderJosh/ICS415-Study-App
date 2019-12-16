<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use DB;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
	}
	
	//Check provider 'google' for driver
	public function redirectToProvider()
	{
		return Socialite::driver('google')->redirect();
	}

	//Manage tokenized provider callback to get user and determine if new or old
	public function handleProviderCallback()
	{
		try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }
        // only allow people with @hawaii.edu to login
		/*
		if(explode("@", $user->email)[1] !== 'hawaii.edu'){
            return redirect()->to('/');
		}
		*/

        // check if they're an existing user
		//Modify by using DB
		$existingUser = User::where('email', $user->email)->first();
		
		if($existingUser){
            // log them in
            auth()->login($existingUser, true);
        } else {
			$authUser = new User;
			$authUser->name = $user->name;
			$authUser->email = $user->email;
			$authUser->google_id = $user->id;
			$authUser->save();

            auth()->login($authUser, true);
        }
        return redirect()->to('/');
	}

	//Logout directive; redirect to home page when done
	public function logoutSession()
	{
		try {
			$user = Socialite::driver('google')->user();
			auth()->logout($user, true);
			return redirect('/');
        } catch (\Exception $e) {
            return redirect('/login');
        }
	}
}
