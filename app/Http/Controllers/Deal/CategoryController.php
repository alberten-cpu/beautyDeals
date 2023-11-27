<?php

namespace App\Http\Controllers\Deal;

use App\DataTables\Admin\Deals\DealCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\DealCategory;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DealCategoryDataTable $dataTable
     * @return mixed
     */
    public function index(DealCategoryDataTable $dataTable): mixed
    {
        return $dataTable->render('template.admin.datatable.datatable', ['title' => 'Deal Categories']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        return view('template.admin.deals.category.create_category');
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
            'category_name' => ['string', 'required', 'min:3', 'unique:deal_category,categoryName']
        ]);
        DB::beginTransaction();
        try {
            DealCategory::create([
                'categoryName' => $request->category_name,
                'categoryStatus' => $request->has('status')
            ]);
            DB::commit();
            return back()->with('success', 'Deal category created successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DealCategory $category
     * @return Application|Factory|View
     */
    public function edit(DealCategory $category): View|Factory|Application
    {
        return view('template.admin.deals.category.edit_category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DealCategory $category
     * @return RedirectResponse
     */
    public function update(Request $request, DealCategory $category): RedirectResponse
    {
        $request->validate([
        'category_name' => ['string', 'required', 'min:3', 'unique:deal_category,categoryName,'.$category->categoryId.',categoryId']
        ]);
        DB::beginTransaction();
        try {
            $category->categoryName = $request->category_name;
            $category->categoryStatus = $request->has('status');
            $category->save();
            DB::commit();
            return back()->with('success', 'Deal category updated successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DealCategory $category
     * @return RedirectResponse
     */
    public function destroy(DealCategory $category): RedirectResponse
    {
        DB::beginTransaction();
        $deleteConformationId = request()->id ?? null;
        try {
            if (($category->deals()->exists() || $category->subCategories()->exists()) && !$deleteConformationId) {
                return redirect()->route('categories.index')
                    ->with(
                        [
                            'delete_confirm' => true,
                            'delete_confirm_id' => $category->categoryId,
                            'delete_confirm_message' => __('This category is associated with some Deals/SubCategories, please confirm to delete'),
                            'delete_confirm_url' => route('categories.destroy', $category->categoryId),
                        ]);
            }
            $category->delete();
            DB::commit();
            return back()->with('success', 'Deal category deleted successfully');
        }catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function viewCategories()
    {

        $categories = DealCategory::with('subCategories')->where('dealCategoryStatus', true)->get();
        if ($categories) {

            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'category Found',
                'data' => $categories,

            ]);

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'category Not Found',

            ]);

        }

    }
}
