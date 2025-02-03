<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\userResource;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ImageUploadTrait;
    public function register(Request $request)
    {
        $agentId = (new User())->generateUniqueUserId();

        // Generate a unique cache key
        $cacheKey = 'temp_user_' . uniqid();

        // Store temporary data in cache
        $tempData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'agent_id' => $agentId,
        ];
        Cache::put($cacheKey, $tempData, now()->addMinutes(30)); // Cache data for 30 minutes

        // Send the email with the cache key (or link to password page)
        Mail::send('emails.password', ['user' => (object) $tempData, 'cacheKey' => $cacheKey], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Set Your Password');
        });

        return response()->json([
            'message' => 'Please set your password from the link sent to your email.',
            'cacheKey' => $cacheKey, // Send cache key back to the frontend for further use
        ]);
    }

    public function addPassword(Request $request)
    {
        $request->validate([
            'cacheKey' => 'required|string',
            'password' => 'required|confirmed|min:6',
        ]);
        $tempData = Cache::get($request->cacheKey);

        if (!$tempData) {
            return response()->json(['message' => 'The link has expired or is invalid.'], 400);
        }
        $user = User::create([
            'name' => $tempData['name'],
            'email' => $tempData['email'],
            'phone' => $tempData['phone'],
            'agent_id' => $tempData['agent_id'],
            'password' => bcrypt($request->password),
        ]);
        Cache::forget($request->cacheKey);

        return response()->json(['message' => 'Account created successfully.']);
    }
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }
        $verificationCode = random_int(100000, 999999);
        Cache::put('verification_code_' . $user->email, $verificationCode, now()->addMinutes(10));
        Mail::send('emails.verification_code', ['code' => $verificationCode], function ($message) use ($user) {
            $message->to($user->email)->subject('Your Verification Code');
        });

        return response()->json(['message' => 'Verification code sent to your email.']);
    }


    // public function verifyCode(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'verification_code' => 'required|integer',
    //     ]);

    //     $cachedCode = Cache::get('verification_code_' . $request->email);

    //     if ($cachedCode && $cachedCode == $request->verification_code) {
    //         return response()->json(['message' => 'Verification successful.']);
    //     } else {
    //         return response()->json(['message' => 'Invalid or expired verification code.'], 400);
    //     }

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         $token = $user->createToken('MyApp')->accessToken;

    //         return response()->json([
    //             'user' => new userResource($user),
    //             'token' => $token
    //         ]);
    //     } else {
    //         return response()->json(['error' => 'Unauthorised'], 401);
    //     }
    // }
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|integer',
        ]);
        $cachedCode = Cache::get('verification_code_' . $request->email);

        if ($cachedCode && $cachedCode == $request->verification_code) {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found.'], 404);
            }
            $token = $user->createToken('MyApp')->accessToken;
            Cache::forget('verification_code_' . $request->email);

            return response()->json([
                'message' => 'Verification successful.',
                'user' => new UserResource($user),
                'token' => $token
            ]);
        }

        return response()->json(['message' => 'Invalid verification code.', 'verification_code_' => $cachedCode], 400);
    }
    public function loginUser()
    {
        $user = Auth::user();

        return new userResource($user);
    }
    public function ProfileUpdateUser(Request $request)
    {
        $user = Auth::user();
    
        $profile = $this->Updateimage($request, 'profile', 'profile', $user->profile);
        $driving = $this->Updateimage($request, 'driving', 'profile', $user->driving_licence);
        $property = $this->Updateimage($request, 'property', 'profile', $user->property_documents);
        $cnic = $this->Updateimage($request, 'cnic', 'profile', $user->cnic);
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->profile = $profile;
        $user->cnic = $cnic;
        $user->driving_licence = $driving;
        $user->property_documents = $property;
    
        $user->save();
    
        return response()->json([
            'message' => 'User Profile Updated Successfully',
            'user' => $user
        ]);
    }

    public function passwordUpdate(Request $request)
    {
        $user = Auth::user();
        if ($request->password){
            $user->password = Hash::make($request->password);
            $user->update();
            return response()->json(['success' => 'Successfully Updated']);
        }
    }

    public function users()
    {
        $user = User::orderBy('id', 'desc')->paginate(10);
        return UserResource::collection($user);
    }
    public function editUser(string $id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }
    public function deleteUser(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => 'Successfully Delete']);
    }
    

    
}
