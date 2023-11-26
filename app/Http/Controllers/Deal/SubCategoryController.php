<?php

namespace App\Http\Controllers\Deal;

use App\DataTables\Admin\Deals\DealSubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\DealSubCategory;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DealSubCategoryDataTable $dataTable
     * @return mixed
     */
    public function index(DealSubCategoryDataTable $dataTable): mixed
    {
        return $dataTable->render('template.admin.datatable.datatable', ['title' => 'Deal SubCategories']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create(): View|Factory|Response|Application
    {
        return view('template.admin.deals.subCategory.create_sub_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function store(Request $request): Response|RedirectResponse
    {
        $request->validate([
            'sub_category_name' => ['string', 'required', 'min:3', 'unique:deal_sub_category,dealSubCategoryName']
        ]);
        DB::beginTransaction();
        try {
            DealSubCategory::create([
                'dealCategoryId' => $request->category,
                'dealSubCategoryName' => $request->sub_category_name,
                'dealSubCategoryStatus' => $request->has('status')
            ]);
            DB::commit();
            return back()->with('success', 'Deal subcategory created successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DealSubCategory $sub_category
     * @return Application|Factory|View
     */
    public function edit(DealSubCategory $sub_category): View|Factory|Application
    {
        return view('template.admin.deals.subCategory.edit_sub_category', compact('sub_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DealSubCategory $sub_category
     * @return RedirectResponse
     */
    public function update(Request $request, DealSubCategory $sub_category): RedirectResponse
    {
        $request->validate([
            'sub_category_name' => ['string', 'required', 'min:3', 'unique:deal_sub_category,dealSubCategoryName,'.$sub_category->dealSubCategoryId.',dealSubCategoryId']
        ]);
        DB::beginTransaction();
        try {
            $sub_category->dealCategoryId = $request->category;
            $sub_category->dealSubCategoryName = $request->sub_category_name;
            $sub_category->dealSubCategoryStatus = $request->has('status');
            $sub_category->save();
            DB::commit();
            return back()->with('success', 'Deal subcategory updated successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DealSubCategory $sub_category
     * @return RedirectResponse
     */
    public function destroy(DealSubCategory $sub_category): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $sub_category->delete();
            DB::commit();
            return back()->with('success', 'Deal subcategory deleted successfully');
        }catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }
}
