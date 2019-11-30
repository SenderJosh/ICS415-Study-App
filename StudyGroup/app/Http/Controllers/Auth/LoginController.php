<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use DB;

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
	
	public function redirectToProvider()
	{
		return Socialite::driver('google')->redirect();
	}

	public function handleProviderCallback()
	{
		try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }
        // only allow people with @hawaii.edu to login
        if(explode("@", $user->email)[1] !== 'hawaii.edu'){
            return redirect()->to('/');
        }
        // check if they're an existing user
		//Modify by using DB
		//$existingUser = User::where('email', $user->email)->first();
		$existingUser = DB::select("SELECT UID FROM dbo.UserTbl WHERE GoogleID = $user->id");
		
		if($existingUser){
            // log them in
            auth()->login($existingUser, true);
        } else {
			$ex = DB::select("INSERT INTO dbo.UserTbl (GoogleID, FirstName, LastName, Email) VALUES ($user")

            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;
            $newUser->save();
            auth()->login($newUser, true);
        }
        return redirect()->to('/');
	}
}
