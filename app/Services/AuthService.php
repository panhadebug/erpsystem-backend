<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
public function login(array $data)
{
$user = User::where(
'email',
$data['email']
)->first();

if (
!$user ||
!Hash::check(
$data['password'],
$user->password
)
) {
throw new Exception(
'Invalid credentials'
);
}

return $user->createToken(
'auth-token'
)->plainTextToken;
}
}