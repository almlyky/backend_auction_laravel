<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('JwtMiddleware', ['except' => ['login']]);
    // }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function login()
    // {
    //     $credentials = request(['phone', 'password']);


    //     if (! $token = auth('api')->attempt($credentials)) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     return response()->json([
    //         // 'user' => Auth::user(),
    //         'cardentials'=>$credentials,
    //         'token' => $token
    //     ]);
    // }

    public function verifyPhone($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (! $user) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        // التحقق من انتهاء المدة
        if ($user->token_expires_at < now()) {
            return response()->json([
                'error' => 'Verification token expired. Please request new one.'
            ], 410); // 410 Gone
        }

        // تم التحقق
        $user->is_verified = true;
        $user->verification_token = null;
        $user->token_expires_at = null;
        $user->save();

        return response()->json(['message' => 'Phone verified successfully']);
    }




    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
        return $this->respondWithToken($token);
    }

    // دالة مساعدة لإنشاء استجابة التوكن
    protected function respondWithToken($token)
    {
        return response()->json([
            "data" => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL()
            ] // مدة الصلاحية بالثواني
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(["data"=>auth('api')->user()]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logouts()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    /**
 * Get the token array structure.
 *
 * @param  string $token
 *
 * @return \Illuminate\Http\JsonResponse
 */
    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60
    //     ]);
    // }
}
