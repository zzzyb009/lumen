<?php

namespace App\Http\Controllers\ChatRoom;
use App\Http\Controllers\Controller;

class ChatRoomController extends Controller
{
    public function __construct()
    {
        //
    }

    public function chatRoom()
    {
        return view('chat.room');
    }

}
