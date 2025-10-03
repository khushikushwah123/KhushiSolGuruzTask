<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{User,Product,UserCart,Order};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        try{
            $validator = Validator::make($request->all(),[
               'name'             => 'required',
               'email'            => 'required|unique:users,email',
               'password'         => 'required|min:6',
               'confirm_password' => 'required|same:password',
               'role'             => 'required|in:Seller,Buyer'
            ]);

            if($validator->fails()) return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);

            $insert                   = new User;
            $insert->name             = $request->name;
            $insert->email            = $request->email;
            $insert->password         = Hash::make($request->password);
            $insert->last_login       = now();
            $insert->role             = $request->role;
            $insert->save();

            $token = $insert->createToken('Task')->plainTextToken;
            $insert['token'] = $token;
            return response()->json(['status'=>true,'message'=>'Registered successfully.','data'=>$insert]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function login(Request $request){
        try{
            $validator =Validator::make($request->all(),[
                'email'    => 'required|exists:users',
                'password' => 'required',
            ]);

            if($validator->fails()) return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);

            $check = User::where('email',$request->email)->first();
            if(!$check) return response()->json(['status'=>false,'message'=>'Account not found']);
            if($check->status == 'Inactive') return response()->json(['status'=>false,'message'=>'Your account is inactivated by admin.']);

            if(Hash::check($request->password,$check->password)){
                $update           = User::find($check->id);
                $update->last_login  = now();
                $update->save();

                $token = $update->createToken('Task')->plainTextToken;
                $update['token'] = $token;

                return response()->json(['status'=>true,'message'=>'Login successfully.','data'=>$update]);
            }else{
                return response()->json(['status'=>false,'message'=>'Invalid password, please try again.']);
            }
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function logout(Request $request){
        try{
            $user = Auth::user()->currentAccessToken()->delete();
            return response()->json(['status'=>true,'message'=>'Logout successfully.']);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function profile(Request $request){
        try{
            $user = Auth::user();
            if($user->status == 'Inactive') return response()->json(['status'=>false,'message'=>'Your account is inactivated by admin.']);
            return response()->json(['status'=>true,'message'=>'Success','data'=>$user]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function product_list(Request $request){
        try{
            $user = Auth::user();
            if($user->status == 'Inactive') return response()->json(['status'=>false,'message'=>'Your account is inactivated by admin.']);

            $products = Product::select('id','name','quantity','image','price','status','stock');
            if($request->search){
                $products = $products->where('name','like', "%".$request->search."%");
            }
            $products = $products->where('status','Active')->latest()->paginate(10);

            foreach($products as $row){
                if($row->stock != 0){
                    $row->in_stock = 'Available';
                }else{
                    $row->in_stock = 'Out of Stock';
                }

                $carts  = UserCart::where('user_id',$user->id)->pluck('product_id');
                if($carts){
                    $chk_cart = $carts->toArray();
                    if(in_array($row->id,$chk_cart)){
                        $total_quantity = UserCart::where('user_id',$user->id)->where('product_id',$row->id)->first();
                        $row->total_quantity = (int)($total_quantity->total_quantity);
                        $row->added_in_cart = true;
                    }else{
                        $row->total_quantity = 0;
                        $row->added_in_cart = false;
                    }
                }else{
                    $row->total_quantity = 0;
                    $row->added_in_cart = false;
                }
            }
            return response()->json(['status'=>true,'message'=>'Success','data'=>['products'=>$products->items(),'total'=>$products->total()]]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function add_cart(Request $request){
        try{
            $user = Auth::user();
            if($user->status == 'Inactive') return response()->json(['status'=>false,'message'=>'Your account is inactivated by admin.']);
            $validator = Validator::make($request->all(),[
                'product_id'      => 'required',
            ]);

            if($validator->fails())  return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);

            $product = Product::where('id',$request->product_id)->first();
            if($product->status == 'Inactive') return response()->json(['status'=>false,'message'=>'Product is inactivated by admin.']);
            if($product->stock == 0) return response()->json(['status'=>false,'message'=>'Sorry, this product is out of stock.']);

            $check = UserCart::where('user_id',$user->id)->where('product_id',$request->product_id)->first();

            if($check){
                $check->total_quantity = $check->total_quantity + 1;
                $check->save();

                $product->stock = $product->stock -1;
                $product->save();

                return response()->json(['status'=>true,'message'=>'Product added in cart successfully..']);
            }else{
                $insert                  = new UserCart;
                $insert->user_id         = $user->id;
                $insert->product_id      = $request->product_id;
                $insert->total_quantity  = 1;
                $insert->save();

                $product->stock = $product->stock -1;
                $product->save();

                return response()->json(['status'=>true,'message'=>'Product added in cart successfully.']);
            }
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function remove_from_cart(Request $request){
        try{
            $user = Auth::user();
            if($user->status == 'Inactive') return response()->json(['status'=>false,'message'=>'Your account is inactivated by admin.']);
            $validator = Validator::make($request->all(),[
                'product_id'      => 'required',
            ]);
            if($validator->fails())  return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);

            $product = Product::where('id',$request->product_id)->first();
            if($product->status == 'Inactive') return response()->json(['status'=>false,'message'=>'Product is inactivated by admin.']);

            $check = UserCart::where('user_id',$user->id)->where('product_id',$request->product_id)->first();

            if($check->total_quantity == 1){
                $check->total_quantity = $check->total_quantity - 1;
                $check->save();

                $product->stock = $product->stock +1;
                $product->save();

                $check->delete();
                return response()->json(['status'=>true,'message'=>'Product remove from cart successfully.']);
            }else{
                $check->total_quantity  = $check->total_quantity - 1;
                $check->save();

                $product->stock = $product->stock +1;
                $product->save();

                return response()->json(['status'=>true,'message'=>'Product remove from cart successfully.']);
            }
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function my_cart(Request $request){
        try{
            $user = Auth::user();
            if($user->status == 'Inactive') return response()->json(['status'=>false,'message'=>'Your account is inactivated by admin.']);
            $carts = UserCart::select('id','user_id','product_id','total_quantity')->where('user_id',$user->id)->get();
            $total_cart_price = 0;
            if(!empty($carts)){
                foreach($carts as $row){
                    $row->product_title    = $row->get_product->name;
                    $row->product_price    = $row->get_product->price;
                    $row->total_quantity   = (int) ($row->total_quantity);

                    $chk_cart = UserCart::where('user_id',$row->user_id)->where('product_id',$row->product_id)->first();
                    if($chk_cart){
                        $total_cart_price += ($chk_cart->get_product->price * $chk_cart->total_quantity);
                    }
                    unset($row->get_product);
                }
            }

            return response()->json(['status'=>true,'message'=>'Success','data'=>['cart_product'=>$carts,'total_price'=>$total_cart_price]]);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function place_order(Request $request){
        try{
            $user = Auth::user();
            if($user->status == 'Inactive') return response()->json(['status'=>false,'message'=>'Your account is inactivated by admin.']);
            $validator = Validator::make($request->all(),[
                'address'           => 'required',
                'product_ids'       => 'required',
                'total_price'       => 'required',
                'date'              => 'required',
            ]);

            if($validator->fails()) return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);

            $arr = [];
            foreach(explode(',',$request->product_ids) as $row){
                $product = Product::where('id',$row)->first();

                if(isset($product) && ($product->status == 'Inactive' || $product->stock == 0)){
                    $arr[] = [$product->id];
                }elseif(!$product){
                    $arr[] = [$row];
                }
            }

            if(count($arr) != 0){
                return response()->json(['status'=>false,'message'=>'Some product are not available ,please refresh your cart.']);
            }

            $insert                           = new Order;
            $insert->user_id                  = $user->id;
            $insert->product_ids              = $request->product_ids;
            $insert->address                  = $request->address;
            $insert->amount                   = $request->total_price;
            $insert->date                     = $request->date;
            $insert->save();

            foreach(explode(',',$request->product_ids) as $row){
                $update = UserCart::where('user_id',$user->id)->where('product_id',$row)->first();
                $update->delete();
            }

            return response()->json(['status'=>true,'message'=>"Order placed successfully.",'data'=>$insert]);

        }catch(Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }
}
