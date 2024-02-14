<?php

namespace App\Http\Controllers\Product;

use App\DataTables\Admin\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductDataTable $dataTable): mixed
    {
        return $dataTable->render('template.admin.datatable.datatable', ['title' => 'Products']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('template.admin.product.create_product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
        ]);

        $product = Product::create([
            'venueId' => $request->venue,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'status' => $request->has('status'),
        ]);
        $destinationPath = createProductFolder($product->id);
        $imagePaths = saveImages($request, 'image', $destinationPath);
        foreach ($imagePaths as $imagePath) {
            ProductImages::create([
                'productId' => $product->id,
                'imagePath' => $imagePath,
                'imageType' => 'banner',
                'status' => true,
            ]);
        }
        return back()->with('success', 'Product created successfully');
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
    public function edit(Product $product)
    {
        $product->load(['productImages', 'venue']);
        return view('template.admin.product.edit_product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        DB::beginTransaction();
        try {
            $product->venueId = $request->venue;
            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->startDate = $request->startDate;
            $product->endDate = $request->endDate;
            $product->status = $request->has('status');
            $product->save();

            if ($request->hasFile('image')) {
                foreach ($product->productImages as $productImage) {
                    if (file_exists(public_path('/Products/' . $product->id . '/' . $productImage?->imagePath))) {
                        unlink(public_path('/Products/' . $product->id . '/' . $productImage?->imagePath));
                    }
                }
                $product->productImages()->delete();
                $destinationPath = createProductFolder($product->id);
                $imagePaths = saveImages($request, 'image', $destinationPath);
                foreach ($imagePaths as $imagePath) {
                    ProductImages::create([
                        'productId' => $product->id,
                        'imagePath' => $imagePath,
                        'imageType' => 'banner',
                        'status' => true,
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Product updated successfully');
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return back()->withErrors($e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            if(is_dir(public_path('/Product/'.$product->id)))
            {
                array_map('unlink', array_filter(
                    (array) array_merge(glob(public_path('/Product/'.$product->id.'/*')))));
                rmdir(public_path('/Product/'.$product->id));
                $product->productImages()->delete();
            }
            $product->delete();
            DB::commit();
            return back()->with('success', 'Product deleted successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function view()
    {
        $products = Product::with('productImages','venue')->where('status',true)->get();
        if ($products) {

            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'Products Found',
                'data' => $products,

            ]);

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Products Not Found',

            ]);

        }

    }

    public function viewEach($productId)
    {
        $products = Product::with('productImages','venue')->where('id','=',$productId)->get();
        if ($products) {

            return response()->json([
                'status' => 200,
                'success' => true,
                'msg' => 'Product Found',
                'data' => $products,

            ]);

        } else {

            return response()->json([
                'status' => 404,
                'success' => false,
                'msg' => 'Product Not Found',

            ]);

        }

    }
}
