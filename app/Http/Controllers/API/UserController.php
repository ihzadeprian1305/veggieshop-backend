<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    use PasswordValidationRules;

    public function login(Request $request)
    {
        try {
            // Input Validation
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);

            // Check Credentials
            $credentials = request(['email','password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error(
                    [
                        'message' => 'Unauthorized'
                    ], 
                    'Authentication Failed', 500);
            }

            // If Result is not as Expected
            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password)){
               throw new \Exception('Invalid Credentials'); 
            }

            // If Success, Allow It
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success(
                [
                    'access_token'=>$tokenResult,
                    'token_type'=> 'Bearer',
                    'user' => $user
                ], 
                'Authenticated');
        } catch (Exception $exception) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something Went Wrong', 
                    'error' => $exception
                ], 'Authentication Failed', 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255',],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
            ]);
            
            User::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'house_number' => $request->house_number,
                    'phone_number' => $request->phone_number,
                    'sub_district' => $request->sub_district,
                    'password' => Hash::make($request->password)
                ]
            );

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success(
                [
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ]
            );
        } catch (Exception $exception) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something Went Wrong',
                    'error' => $exception,
                ], 'Authentication Failed', 500
            );
        }

    }
    
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success(
            $token, 'Token Revoked'            
        );
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'User Profile Data has Succesfully Fetched');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        return ResponseFormatter::success($user, 'Profile Updated');
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048',
        ]);

        if($validator->fails()){
            return ResponseFormatter::error(
                [
                    'error' => $validator->errors(),
                ], 'Upadate Photo Failed', 401);
        }

        if($request->file('file')){
            $file = $request->file->store('assets/user', 'public');

            // Save Photo to Database (URL)
            $user = Auth::user();
            $user->profile_photo_path = $file;
            $user->update();

            return ResponseFormatter::success(
                [$file,],
                'File Succesfully Uploaded'
            );
        }
    }
}
