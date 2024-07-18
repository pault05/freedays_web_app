<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
public function index()
{
// Mock user data (replace with your logic)
$user = [
'first_name' => 'John',
'last_name' => 'Doe',
'email' => 'john.doe@example.com',
'phone' => '+1234567890',
'days_off_left' => 10,
'hired_at' => '01-Jan-2020',
];

return view('user_profile', compact('user'));
}
}
