<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        Session::put('backUrl', url()->previous());
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $userSol = Socialite::driver('facebook')->user();
        $user = null;

        if($userSol->email != null){
            $user = User::where('email',$userSol->email)->first();
        }

        if($user == null){
            $user = User::where('fb_id',$userSol->id)->first();
        }
        
        if($user==null)
        {
            $firstName = explode(" ",$userSol->name);
            $letters = 'abcefghijklmnopqrstuvwxyz!@#$ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $password1 =  substr(str_shuffle($letters), 0, 10);
            $password = bcrypt($password1);
            $user = new User();
            $user->fb_id = $userSol->id;
            $user->name = $userSol->name;
            $user->email = $userSol->email;
            $user->password = $password;
            $user->user_type = '3';
            $user->profile_img = str_replace('normal','large',$userSol->getAvatar());
            $user->type = 'social';
            $user->save();
            auth()->login($user);
        }  else {
            if($user->profile_img =='https://urgolive.kelowna.website/public/images/user_logo.png')
            {
                $user->profile_pic = str_replace('normal','large',$userSol->getAvatar());
                $user->fb_id = $userSol->id;
                $user->save();
            }
            if($user->email == null){
                $user->email = $userSol->email;
                $user->save();
            }
            auth()->login($user);
        }
        return redirect($this->redirectPath());
    }
    
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        Session::put('backUrl', url()->previous());
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        $userSol = Socialite::driver('google')->user();
        $user = User::where('email',$userSol->email)->first();
        if(!$user)
        {
            $firstName = explode(" ",$userSol->name);
            $letters = 'abcefghijklmnopqrstuvwxyz!@#$ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $password1 =  substr(str_shuffle($letters), 0, 10);
            $password = bcrypt($password1);
            $user = new User();
            $user->name = $userSol->name;
            $user->email = $userSol->email;
            $user->password = $password;
            $user->user_type = '3';
            $user->profile_img = str_replace('sz=50','sz=150',$userSol->getAvatar());
            $user->type = 'social';
            $user->save();
            auth()->login($user);
        }
        else
        {
            if($user->profile_pic =='https://urgolive.kelowna.website/public/images/user_logo.png')
            {
                $user->profile_pic = str_replace('sz=50','sz=150',$userSol->getAvatar());
                $user->save();
            }
            auth()->login($user);
        }
        return redirect($this->redirectPath());
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->status) {
            $user->status = 1;
            $user->save();
        }
    }

    public function logout(Request $request) {
        $user = User::find(auth()->user()->id);
        $user->status = 0;
        $user->save();
        auth()->logout();
        return redirect('/');
    }
}
