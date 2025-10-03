<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{Product,UserCart};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Product List';
        $data = Product::query();
        if($request->status_sort && $request->status_sort != 'All'){
            $data = $data->where('status',$request->status_sort);
        }
        if($request->instock_sort && $request->instock_sort != 'All'){
            if($request->instock_sort == 'Out of Stock'){
                $data = $data->where('stock',0);
            }else{
                $data = $data->where('stock','!=',0);
            }
        }
        $data = $data->latest()->get();
        if($request->product_id){
            $update = Product::find($request->product_id);
            $update->status = $request->status;
            $update->save();

            return back()->with('success','Status Changed Successfully.');
        }
        return view('admin::product.index', compact('page_title', 'data'));
    }

    public function create(Request $request)
    {
        $page_title = 'Add Product';
        if($request->submit){
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'image' => 'required|image|max:2048',
                'stock' => 'required',
                'quantity' => 'required',
                'description' => 'required',
            ]);

            $insert = new Product;
            $insert->name = $request->name;
            $insert->price = $request->price;
            if ($request->image) {
                $img = time().'.'.$request->image->extension();
                $request->image->move(public_path('uploads/product_image/'), $img);
                $insert->image = 'public/uploads/product_image/'.$img;
            }
            $insert->stock = $request->stock;
            $insert->quantity = $request->quantity;
            $insert->description = $request->description;
            $insert->save();

            return redirect('admin/products')->with('success','Product Added Successfully.');
        }
        return view('admin::product.create',compact('page_title'));
    }

    public function edit(Request $request, $id)
    {
        $page_title = 'Edit Product';
        $data = Product::find(base64_decode($id));

        if($request->submit){
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'image' => 'image|max:2048',
                'stock' => 'required',
                'quantity' => 'required',
                'description' => 'required',
            ]);

            $data->name = $request->name;
            $data->price = $request->price;
            if ($request->image) {
                $img = time().$key.'.'.$request->image->extension();
                $request->image->move(public_path('uploads/product_image/'), $img);
                $data->image = 'public/uploads/product_image/'.$img;
            }
            $data->stock = $request->stock;
            $data->quantity = $request->quantity;
            $data->description = $request->description;
            $data->save();

            return redirect('admin/products')->with('success','Product Updated Successfully');
        }
        return view('admin::product.edit',compact('page_title','data'));
    }

    public function show(Request $request, $id)
    {
        $page_title = 'Edit Product';
        $data = Product::find(base64_decode($id));

        return view('admin::product.show',compact('page_title','data'));
    }

    public function delete(Request $request, $id)
    {
        $data = Product::find(base64_decode($id));
        UserCart::where('product_id',$data->id)->delete();
        $data->delete();

        return back()->with('success','Product Deleted Successfully.');
    }
}
