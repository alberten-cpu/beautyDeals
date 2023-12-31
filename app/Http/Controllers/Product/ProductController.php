<?php

namespace App\Http\Controllers\Product;

use App\DataTables\Admin\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;

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
