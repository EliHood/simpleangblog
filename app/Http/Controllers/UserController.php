<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\User;
use App\Post;


class UserController extends Controller
{

    public function getRegister()
    {
    	return view('auth/register');
    }

    public function getLogin()
    {
        return view('auth/login');
    }

    public function checkName(Request $request)
    {
        $name = $request['name'];

        $existing_name = User::where('name', '=', $name)->first();

        if($existing_name == NULL){
            return 'name does not exists';

        }
        else{
            return 'name exists';
        }
    }


    public function userSignUp(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|max:120',
    		'password' => 'required|min:6',
    		'name' => 'required|max:80'

    	]);

    	$email = $request['email'];
    	$name = $request['name'];
    	$password = bcrypt($request['password']);

    	$user = new User();
    	$user->email = $email;
    	$user->name = $name;
    	$user->password = $password;

    	$user->save();

    	return redirect('/home');
    }


    public function userSignin(Request $request)
    {
   
        $data = request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $remember = $request->input['remember_me'];

        if (auth()->attempt($data, $remember, true)) {
            return redirect()
                ->intended(route('home'))
                ->withMessage(sprintf('Welcome, %s!', auth()->user()->username));
        }

        return redirect()->guest('login')->withErrors(['Invalid Credentials']);

    }


    public function logOut()
    {
         auth()->logout();

        return redirect()
            ->route('login')
            ->withMessage('See you soon!');
    
    }


    public function getProfile($user)
        {
            $user = User::with(['posts.likes' => function($query) {
                                $query->whereNull('deleted_at');
                            }])
                          ->where('name','=', $user)
                          ->first();

            if(!$user){
                return redirect('404');
            }
            return view ('profile')->withUser($user);
    }

}
