<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// }, ['guards' => ['web', 'auth']]);

Broadcast::channel('public-room', function ($user) {
    return true;
}, ['guards' => ['web']]);

Broadcast::channel('room.{user1_id}.{user2_id}', function ($user1, $user2) {
    return $user1->id === auth()->id() || $user2->id === auth()->id();
}, ['guards' => ['web']]);

// Broadcast::private('private-room.{id}');
