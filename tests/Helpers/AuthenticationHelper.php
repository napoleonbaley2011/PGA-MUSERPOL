<?php

namespace Tests\Helpers;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

trait AuthenticationHelper
{
    public function authenticateUser()
    {
        $user = User::create([
            'username' => 'llima',
            'password' => Hash::make('123456'),
        ]);

        Sanctum::actingAs($user);

        return $user;
    }
}
