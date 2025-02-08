<?php

use Illuminate\Support\Facades\Broadcast;

<<<<<<< HEAD
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('patient-table-head', function ($user) {
    return true; // Allow all authenticated users
});
=======
Broadcast::channel('App.Models.User.{id}', fn($user, $id): bool => (int) $user->id === (int) $id);
>>>>>>> 63c2fd31ad444387cf3fcdad83c7e1290af9eb08
