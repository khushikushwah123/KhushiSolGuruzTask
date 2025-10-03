@extends('admin::layouts.master')
@section('content')
  <!-- Preloader -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{isset($page_title) ? $page_title:''}}</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-12 col-12">

          <div class="card card-default">

          <!-- /.card-header -->
          <div class="card-body">
            @if(session()->has('success'))
            <p class="alert alert-success text-center">{{session()->get('success')}}</p>
            @endif
            <form method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

              <div class="col-md-6">
               <div class="form-group">
                 <label>Name</label>
                 <input class="form-control" type="text" name="name" value="{{old('name',$data->name)}}" style="width: 100%;"/>
                 <p style="color: red;">{{$errors->first('name')}}</p>
               </div>
             </div>

              <div class="col-md-6">
               <div class="form-group">
                 <label>Image</label>
                 <input class="form-control" type="file" name="image" style="width: 100%;"/>
                 <p style="color: red;">{{$errors->first('image')}}</p>
                <img src="{{ asset(str_replace('public/', '', $data->image)) }}" style="width:100x;height:100px;">
               </div>
             </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Price</label>
                  <input class="form-control" type="text" name="price" style="width: 100%;" value="{{old('price',$data->price)}}" />
                  <p style="color: red;">{{$errors->first('price')}}</p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Stock</label>
                  <input class="form-control" type="number" name="stock" style="width: 100%;" value="{{old('stock',$data->stock)}}" />
                  <p style="color: red;">{{$errors->first('stock')}}</p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Quantity</label>
                  <input class="form-control" type="number" name="quantity" style="width: 100%;" value="{{old('quantity',$data->quantity)}}" />
                  <p style="color: red;">{{$errors->first('quantity')}}</p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Status</label>
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option name="Active" {{old('status',$data->status) == 'Active' ? 'selected' : ''}}>Active</option>
                        <option name="Inactive" {{old('status',$data->status) == 'Inactive' ? 'selected' : ''}}>Inactive</option>
                    </select>
                  <p style="color: red;">{{$errors->first('status')}}</p>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name="description" style="width: 100%;" value="" >{{old('description',$data->description)}}</textarea>
                  <p style="color: red;">{{$errors->first('description')}}</p>
                </div>
              </div>


            </div>

            <button class="btn btn-outline-info" name="submit" value="submit" type="submit">Submit</button>
            </form>
          </div>

        </div>




          </div>
          <!-- ./col -->


        </div>


      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @include('admin::layouts.scripts')
  @endsection
