<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deals;
use App\Models\EndUser;
use App\Models\Role;
use App\Models\User;
use App\Models\UserImages;
use App\Models\Venues;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

// api

    public function apiStore(Request $request)
    {
        $request->validate([
            'email' => ['email', 'unique:users'],
            'password' => ['min:8'],
        ]);
        $user = User::create([
            'email' => $request->email,
            'isActive' => true,
            'isMember' => false,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make($request->password),
            'roleId' => Role::ENDUSER,
        ]);
        if ($user) {
            $destinationPath = createUserFolder($user->userId);
            $endUser = EndUser::create([
                'userId' => $user->userId,
                'name' => $request->name,
                'suburb' => $request->suburb,
                'dateOfBirth' => $request->dateOfBirth,
                'userStatus' => true,
            ]);
            $token = $user->createToken('liquo-deals');
            $endUser = EndUser::with('user', 'userimages')->where('userId', '=', $user->userId)->first();
            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'User Created Sucessfully',
                'data' => $endUser,
                'token' => $token,
            ]);

        } else {
            return response()->json([
                'status' => 500,
                'success' => false,
                'msg' => 'Unable to create',

            ]);
        }
    }

    public function apiGetProfile($userId)
    {
        $endUser = EndUser::with('user', 'userimages')->where('userId', '=', $userId)->first();
        $data = [
                'userId' => $endUser->userId,
                'name' => $endUser->name,
                'suburb' => $endUser->suburb,
                'dateOfBirth' => $endUser->dateOfBirth,
                'email' => $endUser->user->email,
                'imagePath' => optional($endUser->userImages->first())->imagePath,
                ];
        if ($endUser) {

            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'User Found',
                'data' => $data,

            ]);

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Venue Not Found',

            ]);

        }
    }
    public function apiUpdate(Request $request)
    {
        $endUser = EndUser::with('user', 'userImages')->where('userId', '=', $request->userId)->first();

        if (!$endUser) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'msg' => 'User not found',
            ]);
        }

        if(isset($request->name)){

            $endUser->name = $request->name;
        }
        if(isset($request->suburb)){

            $endUser->suburb = $request->suburb;
        }
        if(isset($request->dateOfBirth)){

            $endUser->dateOfBirth = $request->dateOfBirth;
        }

        if (isset($request->newPassword)) {

            if (Hash::check($request->oldPassword, $endUser->$user->password)){

                $endUser->$user->password = $request->newPassword;
                $endUser->save();
                $message = 'updated sucessfully';

            }else{

                return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Old password is incorrect',
            ]);
            }

        }

        if (isset($request->profileImage)) {
            $destinationPath = public_path() . '/Users/' . $request->userId . '/';
            $image_no = mt_rand(100, 999); // or any other method to generate a unique number
            $image = $request->profileImage;
            $basename = $destinationPath . $image_no . '.jpg';

            $oldProfileImage = $endUser->userImages()->where('imageType', 'profileImage')->first();
            if ($oldProfileImage) {
                $oldImagePath = $destinationPath . $oldProfileImage->imagePath;
                unlink($oldImagePath); // Delete the old image from the folder
                $oldProfileImage->delete(); // Delete the old record
            }

            // Save the image as a file
            $status = file_put_contents($basename, base64_decode($image));

            // Update or create the 'profileImage' record, ensuring 'userId' matches
            $endUser->userImages()->updateOrCreate(
                ['userId' => $request->userId, 'imageType' => 'profileImage'],
                ['imagePath' => $image_no . '.jpg']
            );

            $message = 'updated sucessfully';
        }

        if ($endUser) {
            $endUser->save();
            $message = 'updated sucessfully';
            $endUser = EndUser::with('user', 'userImages')->where('userId', '=', $request->userId)->first();
            $data = [
                'userId' => $endUser->userId,
                'name' => $endUser->name,
                'suburb' => $endUser->suburb,
                'dateOfBirth' => $endUser->dateOfBirth,
                'email' => $endUser->user->email,
                'imagePath' => $endUser->userImages->first()->imagePath,
                ];
            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'User Updated Successfully',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => $message,
            ]);
        }
    }

    public function viewDeals($dealType)
    {
        $allDeals = viewDealsHelper($dealType);
        $deals = Deals::whereIn('dealId', $allDeals)->with('venue', 'dealRepeat', 'dealImages')->get();
        if ($deals) {

            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'Deals Found',
                'data' => $deals,

            ]);

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Deals Not Found',

            ]);

        }
    }
    public function viewVenues($params)
    {
        if($params == 0){

            $venues = viewVenuesHelper();
        }elseif($params == 1){

            $venues = getCurrentOpenVenues();
        }elseif($params == 2){

            $venues = getCurrentOpenVenuesHasDeal();
        }else{

            $venues = '';
        }

        $venues = Venues::whereIn('venueId', $venues)->with('user', 'images','timing','suburb')->get();
        if ($venues) {

            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'Venues Found',
                'data' => $venues,

            ]);

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Venues Not Found',

            ]);

        }
    }

    public function filterVenues($filterValue)
    {
        if ($filterValue == 1) {

            $venueId = viewVenuesHelper();
        } elseif ($filterValue == 2) {

            $venueId = getCurrentOpenVenues();

        } elseif ($filterValue == 3) {

            $venueId = getCurrentOpenVenuesHasDeal();
        }
        if ($venueId) {
            $venues = Venues::whereIn('venueId', $venueId)->with('user', 'images', 'timing')->get();

            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'Venue Found',
                'data' => $venues,

            ]);

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Venues Not Found',

            ]);

        }
    }

    public function filterDeal(Request $request)
    {
        $searchParams = $request->all();
        $deals = filterByParams($searchParams);
        if ($deals) {
            $deals = Deals::whereIn('dealId', $deals)->with('dealImages', 'dealRepeat','venue','dealCategory','dealsubCategory','venue.suburb')->get();
            
            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'Deals Found',
                'data' => $deals,

            ]);

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Deals Not Found',

            ]);

        }
    }
    public function viewEachDeal($dealId)
    {
        $deals = Deals::where('dealId', $dealId)->with('dealImages', 'dealRepeat')->get();
        if ($deals) {
            // $otherDeals = Deals::where('dealId' != $dealId )->with('user', 'images','timing')->get();

            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'Deals Found',
                'deals' => $deals,
                //'otherDeals' => $otherDeals,

            ]);

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Deals Not Found',

            ]);

        }
    }

    public function viewEachVenue($venueId)
    {
        $venues = Venues::where('venueId', $venueId)
            ->with('user', 'images', 'timing')
            ->get();
        if ($venues) {
            $deals = Deals::with('dealImages', 'dealRepeat','dealCategory','dealsubCategory')->where('venueId', $venueId)
            ->get();
            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'Deals Found',
                'venues' => $venues,
                'deals' => $deals,

            ]);

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Deals Not Found',

            ]);

        }
    }
    
    public function removeAccount($userId)
    {
        $user = User::with('endUser', 'images')->where('userId', $userId)->first();

        if ($user) {
            // Delete related "endUser" records if it's a collection
            if ($user->endUser instanceof \Illuminate\Database\Eloquent\Collection) {
                $user->endUser->each->delete();
            } elseif ($user->endUser) {
                // Delete a single "endUser" if it's a model instance
                $user->endUser->delete();
            }

            // Delete related "images" records if it's a collection
            if ($user->images instanceof \Illuminate\Database\Eloquent\Collection) {
                $user->images->each->delete();
            } elseif ($user->images) {
                // Delete a single "images" record if it's a model instance
                $user->images->delete();
            }

            // Delete the user
            $user->delete();

            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'User Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'User not found',
            ], 404);
        }

    }
    
}
