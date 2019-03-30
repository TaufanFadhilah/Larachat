<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $receiver_id;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(User $user)
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        $chats = null;
        $user = null;
        if (isset($_GET['user'])) {
            $this->receiver_id = $_GET['user'];
            
            $chats = Chat::where(function($query){
                $query->where('user_id', '=', Auth::user()->id)->where('receiver_id', '=', $this->receiver_id);
            })->orWhere(function($query){
                $query->where('user_id', '=', $this->receiver_id)->where('receiver_id', '=', Auth::user()->id);
            })->get();

            $user = User::find($this->receiver_id);
        }

        return view('home', [
            'users' => $users,
            'selectedUser' => $user,
            'chats' => $chats
        ]);
    }
}
