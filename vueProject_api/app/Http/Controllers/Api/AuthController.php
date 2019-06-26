<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\Mail\ResetEmail;
use App\Mail\VrificationEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verify', 'reset', 'setPassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Email or password are incorrect!'],401);
        } else if (auth()->attempt($credentials) && auth()->user()->verification_token !== null) {
            return response()->json(['message' => 'Your email was not verified! please verify it before login'], 500);
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request)
    {
        $token = base64_encode(str_random(140));

        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'verification_token' => $token
        ]);

        Mail::to($user)->send(new VrificationEmail($user));
        return response()->json(['message' => 'success'], 201);
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|exists:users,verification_token'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Your email was already verified!'], 200);
        }

        User::query()->where('verification_token',$request->get('token'))->update([
            'verification_token' => null,
            'email_verified_at' => Carbon::now()
        ]);;

        return response()->json(['message' => 'Your email was successfully verified!'], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
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

    public function reset(Request $request)
    {
        $validator = Validator::make($request->only('email'), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        } else {
            $token = str_random(100);
            $email = $request->get('email');

            DB::table('password_resets')->updateOrInsert([
                'email' => $email
            ], [
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            $user = User::query()->where('email', $email)->first();

            Mail::to($email)->send(new ResetEmail($user, $token));

            return response()->json(['message' => 'Please check your email!'], 201);
        }
    }

    public function setPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string|exists:password_resets,token',
            'password' => 'required|min:6|max:35'
        ]);

        $info = DB::table('password_resets')->where('token', $request->get('token'));

        $infoFirst = $info->first();

        User::query()->where('email', $infoFirst->email)
            ->update([
                'password' => bcrypt($request->get('password'))
            ]);

        $info->delete();

        return response()->json(['message' => 'Your password was successfully changed'], 201);
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
            'user' => auth()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200);
    }
}
