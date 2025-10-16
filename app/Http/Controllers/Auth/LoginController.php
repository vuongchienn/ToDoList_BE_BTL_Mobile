<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Repository\User\UserRepository;
use Illuminate\Auth\Events\Registered;

class LoginController extends Controller
{
    protected $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth:sanctum')->only(['logout', 'getProfile']);
    }
    public function checkEmailExist(Request $request) {
        $email = $request->email;
        if ($this->isEmailExist($email)) {
            return ApiResponse::success( $email ,'Email exist', 200);
        } else {
            return ApiResponse::error('Email not exist', 404);
        }
    }
    public function isEmailExist($email) {
        $user = User::where('email', $email)->first();
        if ($user && $user->status != 0) {
            return true;
        } else {
            return false;
        }
    }
    public function login(Request $request)
    {
        //check email exist
        if (! $this->isEmailExist($request->email)) {
            return ApiResponse::error('Email not exist', 404);
        }
        //check password
        if (! Auth::attempt($request->only('email', 'password'))) {
            return ApiResponse::error('Wrong password', 401);
        }

        $user = auth('sanctum')->user();

        // Xoá token cũ nếu có
        $user->tokens()->delete();

        // Tạo token mới
        $token = $user->createToken($request->email);

        return ApiResponse::success($token->plainTextToken, 'Login successful', 200);
    }

    public function logout() {
        $user = auth('sanctum')->user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'Logout successful',
        ]);
    }
    public function getProfile()
    {
        try {
            $user = auth('sanctum')->user();
            return ApiResponse::success(new UserResource($user), 'Get profile successful', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('Get profile failed', 400);
        }
    }
    public function register(RegisterRequest $registerRequest)
    {
        $userCreate = User::create([
            'email' => $registerRequest->email,
            'password' => Hash::make($registerRequest->password),
        ]);
          // Gửi mail xác minh
        event(new Registered($userCreate));
        if ($userCreate) {
            return ApiResponse::success('Register successful', 201);
        } else {
            return ApiResponse::error('Register failed', 400);
        }
    }
}
