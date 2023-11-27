<?php

namespace App\Http\Controllers\Venue;

use App\DataTables\Admin\VenuesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserImages;
use App\Models\Venues;
use App\Models\VenueTiming;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Web
class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param VenuesDataTable $dataTable
     * @return mixed
     */
    public function index(VenuesDataTable $dataTable): mixed
    {
        return $dataTable->render('template.admin.datatable.datatable', ['title' => 'Venues']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View | Factory | Application
    {
        return view('template.admin.venues.create_venue');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required','email', 'unique:users'],
            'password' => ['required','min:8', 'confirmed'],
            'fileName' => ['required','image','max:10000'],
            'logoName' => ['required','image','max:10000'],
            'menuImage.*' => ['required','image','max:10000'],
            'menuImage' => ['array','max:5'],
            'day' => ['array','present'],
            'otime' => ['array','present'],
            'ctime' => ['array','present'],
        ]);
        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'PhoneNumber' => $request->phone_number,
                'email_verified_at' => Carbon::now()->timestamp,
                'is_verified' => false,
                'isActive' => $request->has('status'),
                'isMember' => $request->has('isMember'),
                'roleId' => Role::USER,
            ]);
            createUserFolder($user->userId);
            $destinationPath = public_path('/Users/'.$user->userId);
            $logoImagePath = saveImage($request, 'logoName', $destinationPath);
            UserImages::create([
                'userId' => $user->userId,
                'imagePath' => $logoImagePath,
                'imageType' => 'logo',
                'status' => true,
            ]);

            $bannerImagePath = saveImage($request, 'fileName', $destinationPath);
            UserImages::create([
                'userId' => $user->userId,
                'imagePath' => $bannerImagePath,
                'imageType' => 'banner',
                'status' => true,
            ]);
            $destinationPath = public_path('/Users/'.$user->userId.'/menuImage/');
            $menuImagePaths = saveImages($request, 'menuImage', $destinationPath);
            foreach($menuImagePaths as $path)
                {
                    UserImages::create([
                        'userId' => $user->userId,
                        'imagePath' => $path,
                        'imageType' => 'menuImage',
                        'status' => true,
                    ]);
                }

            $venue = Venues::create([
                'userId' => $user->userId,
                'venueName' => $request->name,
                'venueDescription' => $request->description,
                'venueType' => $request->category,
                'venueWebsite' => $request->website,
                'venueAddress' => $request->address,
                'suburbId' => $request->suburb,
                'placeName' => $request->placename,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'venueStatus' => $request->has('status'),
            ]);
            $days = $request->day;
            $otime = $request->otime;
            $ctime = $request->ctime;
            foreach ($days as $key => $day) {
                VenueTiming::create([
                    'venueId' => $venue->venueId,
                    'day' => $day,
                    'openTime' => $otime[$key],
                    'closeTime' => $ctime[$key],
                    'status' => true,
                ]);
            }
            DB::commit();
            return back()->with('success', 'Vendor details created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Venues $venue
     * @return Application|Factory|View
     */
    public function edit(Venues $venue): View|Factory|Application
    {
        $venue->load(['user', 'timing','images']);
        return view('template.admin.venues.edit_venue', compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Venues $venue
     * @return RedirectResponse
     */
    public function update(Request $request, Venues $venue): RedirectResponse
    {
        $request->validate([
            'email' => ['email', 'unique:users,email,'.$venue->userId. ',userId'],
            'password' => ['min:8', 'confirmed'],
            'fileName' => ['filled','image','max:10000'],
            'logoName' => ['filled','image','max:10000'],
            'menuImage.*' => ['filled','image','max:10000'],
            'menuImage' => ['filled','array','max:5'],
            'day' => ['array','present'],
            'otime' => ['array','present'],
            'ctime' => ['array','present']
        ]);
        DB::beginTransaction();
        try {
            $venue->user()->update([
                'email' => $request->email,
                'PhoneNumber' => $request->phone_number,
                'isMember' => $request->has('isMember'),
                'isActive' => $request->has('status')
            ]);
            foreach ($venue->images as $image)
            {
                if ($image->imageType == 'logo' && $request->hasFile('logoName')) {
                    if (file_exists(public_path('/Users/' . $image->userId . '/' . $image->imagePath))) {
                        unlink(public_path('/Users/' . $image->userId . '/' . $image->imagePath));
                    }

                    createUserFolder($image->userId);
                    $destinationPath = public_path('/Users/' . $image->userId);
                    $logoImagePath = saveImage($request, 'logoName', $destinationPath);
                    $image->imagePath = $logoImagePath;
                    $image->save();
                }
                if ($image->imageType == 'banner' && $request->hasFile('fileName')) {
                    if (file_exists(public_path('/Users/' . $image->userId . '/' . $image->imagePath))) {
                        unlink(public_path('/Users/' . $image->userId . '/' . $image->imagePath));
                    }
                    createUserFolder($image->userId);
                    $destinationPath = public_path('/Users/' . $image->userId);
                    $bannerImagePath = saveImage($request, 'fileName', $destinationPath);
                    $image->imagePath = $bannerImagePath;
                    $image->save();
                }
                if ($image->imageType == 'menuImage' && $request->menuImage) {
                    if(is_dir(public_path('/Users/'.$venue->user->userId.'/menuImage'))) {
                        array_map('unlink', array_filter(
                            (array)array_merge(glob(public_path('/Users/' . $venue->user->userId . '/menuImage/*')))));
                        rmdir(public_path('/Users/' . $venue->user->userId . '/menuImage'));
                    }
                    $venue->images()->where('imageType','menuImage')->delete();
                    createUserFolder($venue->userId);
                    $destinationPath = public_path('/Users/'.$venue->userId.'/menuImage/');
                    $menuImagePaths = saveImages($request, 'menuImage', $destinationPath);
                    foreach($menuImagePaths as $path)
                    {
                        UserImages::create([
                            'userId' => $venue->userId,
                            'imagePath' => $path,
                            'imageType' => 'menuImage',
                            'status' => true,
                        ]);
                    }
                    break;
                }
            }
            $venue->venueName = $request->name;
            $venue->venueDescription = $request->description;
            $venue->venueType = $request->category;
            $venue->placeName = $request->placename;
            $venue->venueWebsite = $request->website;
            $venue->venueAddress = $request->address;
            $venue->latitude = $request->latitude;
            $venue->longitude = $request->longitude;
            $venue->venueStatus = $request->has('status');
            $venue->save();
            if ($venue->timing()->exists())
            {
                $venue->timing()->delete();
                $days = $request->day;
                $otime = $request->otime;
                $ctime = $request->ctime;
                foreach ($days as $key => $day) {
                    VenueTiming::create([
                        'venueId' => $venue->venueId,
                        'day' => $day,
                        'openTime' => $otime[$key],
                        'closeTime' => $ctime[$key],
                        'status' => true,
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', 'Vendor details updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return back()->withErrors($e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Venues $venue
     * @return RedirectResponse
     */
    public function destroy(Venues $venue): RedirectResponse
    {
        DB::beginTransaction();
        try {
            if(is_dir(public_path('/Users/'.$venue->user->userId)))
            {
                array_map('unlink', array_filter(
                    (array) array_merge(glob(public_path('/Users/'.$venue->user->userId.'/menuImage/*')))));
                rmdir(public_path('/Users/'.$venue->user->userId.'/menuImage'));
                array_map('unlink', array_filter(
                    (array) array_merge(glob(public_path('/Users/'.$venue->user->userId.'/*')))));
                rmdir(public_path('/Users/'.$venue->user->userId));
                $venue->images()->delete();
            }
            $venue->user()->delete();
            $venue->delete();
            DB::commit();
            return back()->with('success', 'Vendor details deleted successfully');
        }catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

// api

    public function apiStore(Request $request): JsonResponse
    {
        $request->validate([
            'venueData' => 'required|array',
            'timeData' => 'required|array',
            // 'venueData.*.name' => 'required|string',
            // 'venueData.*.email' => 'required|email',
            // Add more validation rules for other fields
        ]);
        DB::beginTransaction();

        $venueData = $request->input('venueData')[0];
        $timeData = $request->input('timeData')[0];

        // try {

        $user = User::where('email', $venueData['email'])->first();

        if ($user == null) {

            $user = User::create([
                'email' => $venueData['email'],
                'password' => Hash::make($venueData['password']),
                'phoneNumber' => $venueData['phoneNumber'],
                'email_verified_at' => Carbon::now()->timestamp,
                'is_verified' => false,
                'isActive' => true,
                'isMember' => false,
                'roleId' => Role::USER,
            ]);
            DB::commit();

            if ($user) {
                $destinationPath = createUserFolder($user->userId);
                // $logoImage = public_path('dummyImage/logo.png');
                // $bannerImage = public_path('dummyImage/banner.png');

                $logoImagePath = saveImage($request, 'logo_image', $destinationPath);
                $bannerImagePath = saveImage($request, 'banner_image', $destinationPath);

                $logoImage = UserImages::create([
                    'userId' => $user->userId,
                    'imagePath' => $logoImagePath . '.' . 'png',
                    'imageType' => 'logo',
                    'status' => true,
                ]);
                $bannerImage = UserImages::create([
                    'userId' => $user->userId,
                    'imagePath' => $bannerImagePath . '.' . 'png',
                    'imageType' => 'banner',
                    'status' => true,
                ]);

                $venue = Venues::create([
                    'userId' => $user->userId,
                    'venueName' => $venueData['venueName'],
                    'venueDescription' => $venueData['venueDescription'],
                    'venuePlaceName' => $venueData['venuePlaceName'],
                    'venueWebsite' => $venueData['venueWebsite'],
                    'venueAddress' => $venueData['venueAddress'],
                    'venueLatitude' => $venueData['venueLatitude'],
                    'venueLongitude' => $venueData['venueLongitude'],
                    'venueStatus' => true,
                    'status' => false,
                ]);

                DB::commit();

                if ($venue) {

                    foreach ($timeData as $x => $x_value) {

                        $x_value = explode("-", $x_value);
                        //print_r($x_value[0]);

                        $working = VenueTiming::create([
                            'venueId' => $venue->venueId,
                            'day' => $x,
                            'openTime' => $x_value[0],
                            'closeTime' => $x_value[1],
                            'status' => true,
                        ]);

                    }

                    $venue = Venues::with('user', 'timing', 'images')->find($venue->venueId);

                    return response()->json([
                        'status' => 200,
                        'success' => true,
                        'msg' => 'Venue Created Sucessfully',
                        'data' => $venue,

                    ]);

                } else {

                    DB::rollback();

                    return response()->json([
                        'status' => 422,
                        'success' => false,
                        'msg' => 'Unable to create Venue !! check again with proper data',

                    ]);
                }

            } else {

                DB::rollback();

                return response()->json([
                    'status' => 422,
                    'success' => false,
                    'msg' => 'Unable to create user !! check again with proper data',

                ]);
            }
            // } catch (\Exception $e) {
            //     // An exception occurred, rollback the transaction
            //     DB::rollback();

            //     return response()->json([
            //             'status' => 500,
            //             'success' => false,
            //             'msg' => 'Unable to create !! check again with proper data']);
            // }
        } else {

            return response()->json([
                'status' => 500,
                'success' => false,
                'msg' => 'User Already Exist , Change Email',

            ]);

        }

    }

    public function apiGetProfile($venueId)
    {

        $venue = Venues::with('timing', 'user', 'images','suburb')->where('venueId', '=', $venueId)->first();
        if ($venue) {

            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'Venue Found',
                'data' => $venue,

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
        $venueData = $request->input('venueData')[0];
        $timeData = $request->input('timeData')[0];
        $imageData = $request->input('imageData')[0];

        $venue = Venues::with('user')->where('venueId', '=', $venueData['venueId'])->first();
        if ($venue) {

            if ($imageData != null) {

                $response = 200;

                $venue->images()->delete();

                $destinationPath = public_path('users' . '/' . $venue->userId);

                foreach ($imageData as $imageValue) {

                    $imageName = saveImage($imageData, $destinationPath, 'fileName');

                    $UserImage = UserImages::create([
                        'userId' => $venue->userId,
                        'imagePath' => $imageName,
                        'imageType' => $imageData->imageType,
                        'status' => true,
                    ]);
                }
            }
            if ($timeData != null) {

                $venue->timing()->delete();

                foreach ($timeData as $x => $x_value) {

                    $x_value = explode("-", $x_value);
                    //print_r($x_value[0]);

                    $working = VenueTiming::create([
                        'venueId' => $venueData['venueId'],
                        'day' => $x,
                        'openTime' => $x_value[0],
                        'closeTime' => $x_value[1],
                        'status' => true,

                    ]);

                }

            }

            if ($venueData != null) {

                $venue->user->email = $venueData['email'];
                $venue->user->phoneNumber = $venueData['phoneNumber'];
                $venue->venueName = $venueData['venueName'];
                $venue->venueDescription = $venueData['venueDescription'];
                $venue->venuePlaceName = $venueData['venuePlaceName'];
                $venue->venueWebsite = $venueData['venueWebsite'];
                $venue->venueAddress = $venueData['venueAddress'];
                $venue->venueLatitude = $venueData['venueLatitude'];
                $venue->venueLongitude = $venueData['venueLongitude'];

            }

            if ($venue->isDirty() || $venue->user->isDirty()) {

                $venue->save();
                $venue->user->save();

                $venue = Venues::with('user', 'timing', 'images')->where('venueId', '=', $venueData['venueId'])->first();

                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'msg' => 'Updated Sucessfully',
                    'data' => $venue,

                ]);
            } else {

                return response()->json([
                    'status' => 304,
                    'success' => false,
                    'msg' => 'no changes Made',

                ]);

            }

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Venue Not Found',

            ]);
        }

    }

}
