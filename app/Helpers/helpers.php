<?php

use App\Models\Deals;
use App\Models\Venues;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

function createUserFolder($userId)
{
    // Define the base directory where you want to create user folders (e.g., 'public/Users')
    $userFolderPath = public_path('/Users');

    if (!File::isDirectory($userFolderPath)) {
        File::makeDirectory($userFolderPath, 0777, true, true);
        $baseDirectory = 'Users';
    } else {
        $baseDirectory = 'Users';
    }

    // Create a directory path for the user using the base directory and user ID
    $userFolderPath = public_path($baseDirectory . '/' . $userId);

    // Check if the directory already exists, and create it if it doesn't
    if (!File::isDirectory($userFolderPath)) {
        File::makeDirectory($userFolderPath, 0777, true, true);
    }

    // Return the path of the created folder
    return $userFolderPath;
}

function createDealFolder($dealId)
{
    // Define the base directory where you want to create user folders (e.g., 'public/Users')
    $userFolderPath = public_path('/Deals');

    if (!File::isDirectory($userFolderPath)) {
        File::makeDirectory($userFolderPath, 0777, true, true);
        $baseDirectory = 'Deals';
    } else {
        $baseDirectory = 'Deals';
    }

    // Create a directory path for the user using the base directory and user ID
    $userFolderPath = public_path($baseDirectory . '/' . $dealId);

    // Check if the directory already exists, and create it if it doesn't
    if (!File::isDirectory($userFolderPath)) {
        File::makeDirectory($userFolderPath, 0777, true, true);
    }

    // Return the path of the created folder
    return $userFolderPath;
}

function isBase64Image($imageData)
{
    // Check if $imageData is a valid base64 string
    if (base64_decode($imageData, true) !== false) {
        // If it's already a valid base64 string, return it as is
        return $imageData;
    } else {
        if ($imageData instanceof UploadedFile) {
            // Get the path to the temporary file
            $filePath = $imageData->getPathname();

            // Read the contents of the file
            $fileContents = File::get($filePath);
            // Log::info('File Contents:', ['contents' => $fileContents]);

            // Encode the file contents to base64
            $base64Data = base64_encode($fileContents);

            return $base64Data;
        }

        // Handle the case where $imageData is not a valid base64 string
        return null;
    }
}

function saveImage(Request $request, $imageName, $destinationPath)
{
    $uploadedImage = $request->file($imageName);

    // Generate a unique file name
    $fileName = uniqid() . time() . '.png';

    // Move the uploaded image to the specified destination path with the new file name
    $uploadedImage->move($destinationPath, $fileName);

    return $fileName;
}

function saveImages(Request $request, $imageName, $destinationPath)
{
    $uploadedImage = $request->file($imageName);
    $paths = [];
    foreach ($uploadedImage as $images) {
        $fileName = uniqid() . time() . '.png';
        $images->move($destinationPath, $fileName);
        $paths[] = $fileName;
    }
    return $paths;
}

if (!function_exists('viewDealsHelper')) {
    function viewDealsHelper($dealType)
    {
        $dealId = [];
        $query = Deals::query();

        if ($dealType === 0) {
            // If dealType is 'All', select all deals
            $query->where('status', true);
        } elseif ($dealType == 1) {
            // If a specific dealType is provided, select deals matching that type
            $query->where('status', true)
                ->where('isExclusive', $dealType);
        } else {

            $query->where('status', true);
        }

        $deals = $query->get();

        foreach ($deals as $deal) {

            $dealId[] = $deal->dealId;
        }

        return $dealId;
    }
}

if (!function_exists('viewVenuesHelper')) {
    function viewVenuesHelper()
    {
        $venueId = [];
        $venues = Venues::with('user')->where('venueStatus', true)->get();
        foreach ($venues as $venue) {

            if ($venue->user->isActive == 1) {

                $venueId[] = $venue->venueId;

            }
        }

        return $venueId;
    }
}
if (!function_exists('getCurrentOpenVenues')) {
    function getCurrentOpenVenues(): array
    {
        $viewVenuesHelper = viewVenuesHelper();
        $currentTime = date("H:i:s");
        $currentDayOfWeek = strtolower(Carbon::now()->format('l'));
        $openVenues = [];
        $venues = Venues::whereIn('venueId', $viewVenuesHelper)
            ->with('user', 'timing')->get();
        foreach ($venues as $venue) {
            foreach ($venue->timing as $timing) {
                if ($currentDayOfWeek === $timing->day) {
                    $openTime = $timing->openTime;
                    $closeTime = $timing->closeTime;

                    if (strtotime($currentTime) >= strtotime($openTime) && strtotime($currentTime) <= strtotime($closeTime)) {
                        echo "Venue is open.";
                        $openVenues[] = $venue->venueId;
                    }
                }
            }
        }
        return $openVenues;
    }
}
if (!function_exists('getCurrentOpenDeals')) {
    function getCurrentOpenDeals(): array
    {
        $getCurrentOpenVenues = getCurrentOpenVenues();
        $viewDealsHelper = viewDealsHelper(0);
        $currentOpenDeals = [];
        $isRepeatDeals1 = [];
        $isRepeatDeals2 = [];
        $isRepeatDeals3 = [];
        $currentDayOfWeek = strtolower(Carbon::now()->format('l'));
        $currentTime = Carbon::now()->toTimeString();
        $carbonCurrentTime = Carbon::parse($currentTime);
        $currentDate = Carbon::now()->toDateString();
        $carbonCurrentDate = Carbon::parse($currentDate);
        $currentWeekNumber = Carbon::now()->weekOfYear;
        $deals = Deals::whereIn('dealId', $viewDealsHelper)->whereIn('venueId', $getCurrentOpenVenues)
            ->where('status', true)->with('dealRepeat')->get();

        foreach ($deals as $deal) {
            foreach ($deal->dealRepeat as $timing) {
                $dealRepeatStartDate = Carbon::parse($deal->startDate);
                $dealRepeatendDate = Carbon::parse($deal->repeatEndDate);
                $carbonOpenTime = Carbon::parse($timing->sTime);
                $carbonCloseTime = Carbon::parse($timing->eTime);
                if ($carbonCurrentDate->gte($dealRepeatStartDate) && $carbonCurrentDate->lte($dealRepeatendDate)) {

                    if ($deal->isRepeat == 1) {

                        if ($currentDayOfWeek === $deal->dealRepeat->repeat) {
                            if ($carbonCurrentTime->gte($carbonOpenTime) && $carbonCurrentTime->lte($carbonCloseTime)) {
                                $isRepeatDeals1[] = $deal->dealRepeat->dealId;
                            }
                        }

                    }
                    if ($deals->isRepeat == 2) {
                        $repeatWeeks = explode("-", $deal->repeatWeeks);
                        if (in_array($currentWeekNumber, $repeatWeeks)) {
                            if ($currentDayOfWeek === $deal->dealRepeat->repeat) {
                                if ($carbonCurrentTime->gte($carbonOpenTime) && $carbonCurrentTime->lte($carbonCloseTime)) {
                                    $isRepeatDeals2[] = $deal->dealRepeat->dealId;
                                }
                            }

                        }

                    }
                    if ($deals->isRepeat == 3) {

                        $carbonDealDate = Carbon::parse($deal->dealRepeat->repeat);
                        if ($carbonCurrentDate->equalTo($carbonDealDate)) {
                            if ($carbonCurrentTime->gte($carbonOpenTime) && $carbonCurrentTime->lte($carbonCloseTime)) {
                                $isRepeatDeals3[] = $deal->dealRepeat->dealId;
                            }
                        }

                    }

                }
            }

        }
        $mergedArray = array_merge($isRepeatDeals1, $isRepeatDeals2, $isRepeatDeals3);
        $currentOpenDeals = array_unique($mergedArray);
        return $currentOpenDeals;

    }
}

if (!function_exists('getCurrentOpenVenuesHasDeal')) {
    function getCurrentOpenVenuesHasDeal(): array
    {
        $openDeals = getCurrentOpenDeals();
        $openVenueshasDeal = [];
        $deals = Deals::whereIn('dealId', $openDeals)->get();
        foreach ($deals as $deal) {

            $openVenues[] = $deal->venueId;
        }

        return $openVenueshasDeal;
    }

}

if (!function_exists('categoryDeals')) {
    function filterByParams(array $searchParams): array
    {
        $filterDeals = [];
        $conditions = $searchParams;
        $currentopenDeals = getCurrentOpenDeals();
        $deals = Deals::whereIn('dealId', $currentopenDeals)
            ->where(function ($query) use ($conditions) {
                foreach ($conditions as $field => $value) {
                    $query->where($field, $value);
                }
            })
            ->get();
        foreach ($deals as $deal) {

            $filterDeals[] = $deal->dealId;
        }

        return $filterDeals;
    }

}
