<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Policies\TaskPolicy;
use App\MyFollow;
use App\User;
use App\Post;
use Image;


class UserController extends Controller
{

    public function uploadpic(Request $request)
    {   

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );

            $user = auth()->user();
            $user->avatar = $filename;
            $user->save();

            return view('profile')->withUser($user);
        }

        if(!$user)
        {
            return redirect('/home');
        }


        
    }
    public function my_follow(Request $request, $id)
    {
        $user = auth()->user();

        if($user->id != $id && $otherUser = User::find($id)){

            $user->toggleFollow($otherUser);
        }

        

    }



    public function getRegister()
    {
    	return view('auth/register');
    }

    public function getLogin()
    {
        return view('auth/login');
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

        $check = User::CheckName($name)->first();

        if($check){

            return back()->with('message', 'Username already in Use'); 
        }else{
            
            $user->save();

            return redirect('/home');

        }


    	
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
        $users = User::with(['posts.likes' => function($query) {
                            $query->whereNull('deleted_at');
                            $query->where('user_id', auth()->user()->id);
                        }, 'followers','follow.followers'])

                        ->with(['followers' => function($query) {
                 

                        }])->where('name','=', $user)->get();

        $user = $users->map(function(User $myuser){
            
            $myuser['followedByMe'] = $myuser->getIsFollowingAttribute();
            
            return $myuser;
        });


        if(!$user){
            return redirect('404');
        }

        return view ('profile')->with('user', $user);
    }
    

}
