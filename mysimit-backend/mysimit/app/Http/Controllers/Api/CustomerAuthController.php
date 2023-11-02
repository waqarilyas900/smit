<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Customer;
use App\Enums\AddressType;
use App\Enums\ActiveStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class CustomerAuthController extends Controller
{
    /**
     * Register a new seller on the application
     *
     * @param \Illuminate\Http\Request $request
     */
    public function register(Request $request)
    {
        // Validate the request
        $validated = $this->validate($request, [
            'firstName'                => 'required|string|between:2,100',
            'lastName'                 => 'required|string|between:2,100',
            'email'                    => 'required|email|max:100|unique:customers',
            'phone'                    => 'required|string|max:15|unique:customers',
            'password'                 => 'required|string|confirmed|min:6',
        ]);

        $customer = Customer::create(array_merge(
            $request->only('firstName', 'lastName', 'email', 'phone'),
            ['password' => bcrypt($request->password)]
        ));
        return new ApiResource($customer);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $this->validate(request(), [
            'email' => 'required|email|max:255|exists:customers',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or password is not correct'], 401);
        }

        // Update last login and status
        auth()->user()->update([
            'lastLogin' => Carbon::now(),
            'status'    => ActiveStatus::ACTIVE()
        ]);

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}