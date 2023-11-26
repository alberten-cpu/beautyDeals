<?php

namespace App\Http\Controllers;

use App\Models\EndUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Venues;

class LoginController extends Controller
{
    public function loginUser(Request $request)
    {

        $user = User::where('email', '=', $request->email)
            ->where('roleId', '=', $request->role)
            ->where('isActive', '=', true)
            ->first();
        if($user) {

            if ($user->roleId == Role::USER) {

                if ($user->email_verified_at != NULL) {

                    if (Hash::check($request->password, $user->password)) {

                        $token = $user->createToken('liquo-deals');

                        $venue = Venues::with('timing','user','images')->where('userId', '=', $user->userId)

                        ->first();

                        return response()->json([
                            'status' => 200,
                            'success' => true,
                            'msg' => 'Login Successfully',
                            'data' => $venue,
                            'token' => $token

                        ]);
                    } else {
                        return response()->json([
                            'status' => 401,
                            'success' => true,
                            'msg' => 'Incorrect password, please try again'

                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 403,
                        'success' => true,
                        'msg' => 'account not verified !! , kindly check mail for activate Link !!'

                    ]);
                }
            }else{
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('liquo-deals');
                    // dd($user->userId);
                    $user = User::with('endUser','images')->where('userId', '=', $user->userId)->get();
                    return response()->json([
                        'status' => 200,
                        'success' => true,
                        'msg' => 'Login Successfully',
                        'data' => $user,
                        'token' => $token

                    ]);
                } else {
                    return response()->json([
                        'status' => 401,
                        'success' => true,
                        'msg' => 'Incorrect password, please try again'

                    ]);
                }
            }
        }else{

            return response()->json([
                'status' => 404,
                'success' => true,
                'msg' => 'The email address provided is not linked to an account'

            ]);
        }
    }
}
