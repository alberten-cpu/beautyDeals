<?php

namespace App\Http\Controllers\Deal;

use App\DataTables\Admin\Deals\DealsDataTable;
use App\Http\Controllers\Controller;
use App\Models\DealImages;
use App\Models\DealRepeat;
use App\Models\Deals;
use App\Models\DealSubCategory;
use App\Models\Venues;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DealsDataTable $dataTable
     * @return mixed
     */
    public function index(DealsDataTable $dataTable): mixed
    {
        return $dataTable->render('template.admin.datatable.datatable', ['title' => 'Deals']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('template.admin.deals.create_deal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'category' => ['required'],
            'sub_category' => ['required'],
            'price' => ['required'],
            'is_repeat' => ['required'],
            'week' => ['array','required_if:is_repeat,2'],
            'date' => ['required_if:is_repeat,3'],
            'day' => ['array', 'required_unless:is_repeat,3'],
            'otime.0' => ['required'],
            'ctime.0' => ['required'],
        ],[
            'week.required_if' => 'Week is a required field',
            'date.required_if' => 'Date is a required field',
            'day.required_unless' => 'Day is a required field',
            'otime.0.required' => 'Opening Time is a required field',
            'ctime.0.required' => 'Closing Time is a required field',
        ]);
        if (!Venues::getUserByVenueId($request->venue)->isMember && Deals::dealCountByVenueId($request->venue) >= 20) {
            $message = 'The venue user is not a member, Only member can create more than 20 deals';
            if(auth()->user()->isUser())
            {
                $message = 'You are not a member, Only member can create more than 20 deals';
            }
            throw ValidationException::withMessages(['venue' => $message]);
        }
        DB::beginTransaction();
        try {
            $deal = Deals::create([
                'venueId' => $request->venue,
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'subCategory' => $request->sub_category,
                'price' => $request->price,
                'isRepeat' => $request->is_repeat,
                'startDate' => $request->startDate,
                'repeatEndDate' => $request->endDate,
                'isExclusive' => $request->has('isExclusive'),
                'status' => $request->has('status'),
            ]);
            if ($request->is_repeat == 2) {
                $deal->repeatWeeks = implode('-', $request->week);
                $deal->save();
            }
            if ($request->is_repeat == 3) {
                $deal->startDate = $request->date;
                $deal->repeatEndDate = $request->date;
                $deal->save();
            }
            $otime = $request->otime;
            $ctime = $request->ctime;
            if ($request->is_repeat != 3) {
                $days = $request->day;
                foreach ($days as $key => $day) {
                    DealRepeat::create([
                        'dealId' => $deal->dealId,
                        'sTime' => $otime[$key],
                        'eTime' => $ctime[$key],
                        'repeat' => $day,
                        'status' => true,
                    ]);
                }
            } else {
                DealRepeat::create([
                    'dealId' => $deal->dealId,
                    'sTime' => $otime[0],
                    'eTime' => $ctime[0],
                    'repeat' => $request->date,
                    'status' => true,
                ]);
            }

            $destinationPath = createDealFolder($deal->dealId);
            $imagePaths = saveImages($request, 'image', $destinationPath);
            foreach ($imagePaths as $imagePath)
            {
                DealImages::create([
                    'dealId' => $deal->dealId,
                    'imagePath' => $imagePath,
                    'imageType' => 'banner',
                    'status' => true,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Deal created successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $deals
     * @return JsonResponse|void
     */
    public function show(string $deals)
    {
        if (\request()->ajax()) {
            $search = request()->search;
            $id = request()->id;
            $subcategories = DealSubCategory::select('dealSubCategoryId', 'dealSubCategoryName')->where('dealCategoryId', $deals)->when(
                $search,
                function ($query) use ($search) {
                    $query->where('dealSubCategoryName', 'like', '%' . $search . '%');
                }
            )->when($id, function ($query) use ($id) {
                $query->where('dealSubCategoryId', $id);
            })->limit(15)->get();
            $response = [];
            foreach ($subcategories as $subcategory) {
                $response[] = [
                    'id' => $subcategory->dealSubCategoryId,
                    'text' => $subcategory->dealSubCategoryName,
                ];
            }

            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Deals $deal
     * @return Application|Factory|View
     */
    public function edit(Deals $deal): View|Factory|Application
    {
        $deal->load(['dealRepeat', 'dealImages']);
        return view('template.admin.deals.edit_deal', compact('deal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Deals $deal
     * @return RedirectResponse
     */
    public function update(Request $request, Deals $deal): RedirectResponse
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'category' => ['required'],
            'sub_category' => ['required'],
            'price' => ['required'],
            'is_repeat' => ['required'],
            'week' => ['array','required_if:is_repeat,2'],
            'date.0' => ['required_if:is_repeat,3'],
            'day' => ['array', 'required_unless:is_repeat,3'],
            'otime.0' => ['required'],
            'ctime.0' => ['required'],
        ],[
            'week.required_if' => 'Week is a required field',
            'date.0.required_if' => 'Date is a required field',
            'day.required_unless' => 'Day is a required field',
            'otime.0.required' => 'Opening Time is a required field',
            'ctime.0.required' => 'Closing Time is a required field',
        ]);
        DB::beginTransaction();
        try {
            $deal->venueId = $request->venue;
            $deal->title = $request->title;
            $deal->description = $request->description;
            $deal->category = $request->category;
            $deal->subCategory = $request->sub_category;
            $deal->price = $request->price;
            $deal->isRepeat = $request->is_repeat;
            $deal->startDate = $request->startDate;
            $deal->repeatEndDate = $request->endDate;
            $deal->isExclusive = $request->has('isExclusive');
            $deal->status = $request->has('status');

            if ($request->is_repeat == 2) {
                $deal->repeatWeeks = implode('-', $request->week);
            }
            if ($request->is_repeat == 3) {
                $deal->startDate = $request->date[0];
                $deal->repeatEndDate = $request->date[0];
            }
            $deal->save();
            $deal->dealRepeat()->delete();

            $otime = $request->otime;
            $ctime = $request->ctime;
            if ($request->is_repeat != 3) {
                $days = $request->day;
                foreach ($days as $key => $day) {
                    DealRepeat::create([
                        'dealId' => $deal->dealId,
                        'sTime' => $otime[$key],
                        'eTime' => $ctime[$key],
                        'repeat' => $day,
                        'status' => true,
                    ]);
                }
            } else {
                DealRepeat::create([
                    'dealId' => $deal->dealId,
                    'sTime' => $otime[0],
                    'eTime' => $ctime[0],
                    'repeat' => $request->date[0],
                    'status' => true,
                ]);
            }
            if ($request->hasFile('image')) {
                foreach ($deal->dealImages as $dealImage) {
                    if (file_exists(public_path('/Deals/' . $deal->dealId . '/' . $dealImage?->imagePath))) {
                        unlink(public_path('/Deals/' . $deal->dealId . '/' . $dealImage?->imagePath));
                    }
                }
                $deal->dealImages()->delete();
                rmdir(public_path('/Deals/' . $deal->dealId));
                $destinationPath = createDealFolder($deal->dealId);
                $imagePaths = saveImages($request, 'image', $destinationPath);
                foreach ($imagePaths as $imagePath) {
                    DealImages::create([
                        'dealId' => $deal->dealId,
                        'imagePath' => $imagePath,
                        'imageType' => 'banner',
                        'status' => true,
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Deal updated successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Deals $deal
     * @return RedirectResponse
     */
    public function destroy(Deals $deal): RedirectResponse
    {
        DB::beginTransaction();
        try {
            if(is_dir(public_path('/Deals/'.$deal->dealId)))
            {
                array_map('unlink', array_filter(
                    (array) array_merge(glob(public_path('/Deals/'.$deal->dealId.'/*')))));
                rmdir(public_path('/Deals/'.$deal->dealId));
                $deal->dealImages()->delete();
            }
            $deal->delete();
            DB::commit();
            return back()->with('success', 'Deal deleted successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }
}
