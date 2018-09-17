<?php
$router->group(['namespace' => 'ChatRoom'], function() use ($router) {
    $router->get('v1/chat/chatRoom', ['as' => 'chatRoom.chatRoom', 'uses' => 'ChatRoomController@chatRoom', function () {}]); //
});