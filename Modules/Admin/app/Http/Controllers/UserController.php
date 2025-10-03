<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{Product,User,Order};
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){

        $page_title = $request->type == 'Seller' ? 'Seller User' : 'Buyer User';
        $data = User::query();
        if($request->status_sort && $request->status_sort != 'All'){
            $data = $data->where('status',$request->status_sort);
        }
        if($request->hasorders_sort && $request->hasorders_sort != 'All'){
            if ($request->hasorders_sort == 'Has Orders') {
                $data = $data->has('orders');
            } else {
                $data = $data->doesntHave('orders');
            }
        }
        $data = $data->where('role',$request->type)->latest()->get();
        foreach($data as $row){
            $check = Order::where('user_id',$row->id)->count();
            $row->total_orders = isset($check) ? $check : 0;
        }
        if($request->user_id){
            $update = User::find($request->user_id);
            $update->status = $request->status;
            $update->save();

            return back()->with('success','Status Changed Successfully');
        }
        return view('admin::user.index', compact('page_title', 'data'));
    }
}
