@extends('admin::layouts.master')
@section('content')
    <main>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ $page_title }}</h1>
                        </div>
                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box ">
                                <div class="inner">
                                    <h3>{{$products}}</h3>
                                    <p>Products</p>
                                </div>
                                <div class="icon"><i class="ion ion-bag"></i></div>
                                <a href="{{url('admin/products')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box ">
                                <div class="inner">
                                    <h3>{{$seller}}</h3>
                                    <p>Seller</p>
                                </div>
                                <div class="icon"><i class="ion ion-bag"></i></div>
                                <a href="{{url('admin/users?type=Seller')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box ">
                                <div class="inner">
                                    <h3>{{$buyers}}</h3>
                                    <p>Buyer</p>
                                </div>
                                <div class="icon"><i class="ion ion-bag"></i></div>
                                <a href="{{url('admin/users?type=Buyer')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </main>
    @include('admin::layouts.scripts')
@endsection
