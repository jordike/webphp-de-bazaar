<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'fields' => [
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'remember' => 'Remember me',
    ],

    'registration' => [
        'register' => 'Register',
        'role' => [
            'register_as' => 'Register as',
            'select_role' => 'Select a role',
        ],
        'already_account' => 'Already have an account?',
        'login' => 'Login',
        'success' => 'Registration successful. You can now log in.',
    ],

    'login' => [
        'login' => 'Login',
        'no_account' => 'Don\'t have an account?',
        'create_account' => 'Create an account',
        'error' => 'The provided credentials do not match our records.',
        'success' => 'Login successful. Welcome back!',
    ],

    'logout' => [
        'success' => 'You have been logged out successfully.',
    ],
];
