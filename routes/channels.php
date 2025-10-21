<?php

use Illuminate\Broadcasting\Broadcast;
use Illuminate\Support\Facades\Broadcast as BroadcastFacade;

BroadcastFacade::channel('user.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});
