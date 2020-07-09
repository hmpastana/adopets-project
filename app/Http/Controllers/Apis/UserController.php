<?php

namespace App\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;
use Webpatser\Uuid\Uuid;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'uuid' => (string) Uuid::generate(4)
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

                if (! $user = JWTAuth::parseToken()->authenticate()) {
                        return response()->json(['user_not_found'], 404);
                }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function logout() {

        $this->logHistory();

        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'status' => 'success',
                'msg' => 'You have successfully logged out.'
            ]);
        } catch (JWTException $e) {
            JWTAuth::unsetToken();
            // something went wrong tries to validate a invalid token
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to logout, please try again.'
            ]);
        }
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return response()->json($user, 201);

    }

    public function delete(Request $request, User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

    // public function index()
    // {
    //     return response()->json(User::get(), 200);
    // }
    //
    // public function show($id)
    // {
    //     $user = User::find($id);
    //     if(is_null($user)){
    //         return response()->json(null,404);
    //     }
    //     return response()->json(User::find($id), 200);
    // }
    //
    //
    // public function errors()
    // {
    //     return response()->json(['msg' => 'Data is missing'], 501);
    // }

}
