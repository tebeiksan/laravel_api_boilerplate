<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidAccessTokenException;
use App\Exceptions\UserInactiveException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserWrongCredentialsException;
use App\Helpers\UserHelper;
use App\Http\Requests\LoginGoogleRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\LoginResource;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Google\Client as GoogleClient;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {

            $user = User::where("email", $request->email)->first();

            if (!$user) {
                throw new UserNotFoundException();
            }

            if (Hash::check($request->password, $user->password)) {

                if ($user->is_active == UserHelper::USER_INACTIVE) {
                    throw new UserInactiveException();
                }

                $authenticatedUser = $this->generateJwt($user);

                return new LoginResource($authenticatedUser);
            }

            throw new UserWrongCredentialsException();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function loginGoogle(LoginGoogleRequest $request)
    {
        try {
            $client = new GoogleClient(['client_id' => env('GOOGLE_OAUTH_CLIENT_ID')]);

            $payload = $client->verifyIdToken($request->access_token);

            if ($payload) {

                $user = User::where("email", $payload["email"])->first();

                if (!$user) {
                    throw new UserNotFoundException();
                }

                if ($user->is_active == UserHelper::USER_INACTIVE) {
                    throw new UserInactiveException();
                }

                $authenticatedUser = $this->generateJwt($user);

                return new LoginResource($authenticatedUser);
            }

            throw new InvalidAccessTokenException();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function logout()
    {
        try {
            Auth::logout(true);

            return new BaseResource([], "Logout success");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function profile()
    {
        try {
            $user = Auth::user();

            return new ProfileResource($user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function generateJwt($user)
    {
        try {
            /**
             * Set expired jwt to end of day
             * or you can adjust expired time in setTTL method
             */

            $date = Carbon::now();
            $ttl = (int) floor($date->secondsUntilEndOfDay() / 60);

            $login = Auth::claims([
                'user' => [
                    "name" => $user->name,
                ],
                "roles" => $user->roles->pluck('name'),
                "permissions" => $user->getAllPermissions()->pluck('name'),
            ])
                ->setTTL($ttl)
                ->login($user);

            return collect($user)->merge([
                'token' => $login
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
