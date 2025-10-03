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
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="btn btn-outline-info" href="{{url('admin/add-product')}}">Add</a></li>
                <li class="breadcrumb-item">
                    <form>
                        <label>Sort By</label>
                        <input type="hidden" name="type" value="{{ $_GET['type'] }}">
                        <select name="status_sort" class="form-control" onchange="this.form.submit()">
                            <option name="All" {{isset($_GET['status_sort']) && $_GET['status_sort'] == 'All' ? 'selected' : ''}}>All</option>
                            <option name="Active" {{isset($_GET['status_sort']) && $_GET['status_sort'] == 'Active' ? 'selected' : ''}}>Active</option>
                            <option name="Inactive" {{isset($_GET['status_sort']) && $_GET['status_sort'] == 'Inactive' ? 'selected' : ''}}>Inactive</option>
                        </select>
                    </form>
                </li>
                <li class="breadcrumb-item">
                    <form>
                        <label>Have Orders</label>
                        <input type="hidden" name="type" value="{{ $_GET['type'] }}">
                        <select name="hasorders_sort" class="form-control" onchange="this.form.submit()">
                            <option name="All" {{isset($_GET['hasorders_sort']) && $_GET['hasorders_sort'] == 'All' ? 'selected' : ''}}>All</option>
                            <option name="Has Orders" {{isset($_GET['hasorders_sort']) && $_GET['hasorders_sort'] == 'Has Orders' ? 'selected' : ''}}>Has Orders</option>
                            <option name="Has not Orders" {{isset($_GET['hasorders_sort']) && $_GET['hasorders_sort'] == 'Has not Orders' ? 'selected' : ''}}>Has not Orders</option>
                        </select>
                    </form>
                </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-lg-12 col-12">


          <div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div> -->
            @if(session()->has('success'))
            <p class="alert alert-success text-center">{{session()->get('success')}}</p>
            @endif

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Last Login</th>
                    <th>Total Orders</th>
                    <th>Status</th>
                    <th>Registered At</th>
                  </tr>
                  </thead>
                  <tbody>
                  @php $i=0 @endphp
                  @if(isset($data) && count($data) > 0 )
                  @foreach($data as $key => $row)
                  <tr>
                    <td>{{++$i}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->email}}</td>
                    <td>{{ Carbon\Carbon::parse($row->last_login)->format('d M Y h:i A') }}</td>
                    <td>{{ $row->total_orders }}</td>
                    <td>
                        <form>
                            <input type="hidden" name="user_id" value="{{$row->id}}">
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option name="Active" {{$row->status == 'Active' ? 'selected' : ''}}>Active</option>
                                <option name="Inactive" {{$row->status == 'Inactive' ? 'selected' : ''}}>Inactive</option>
                            </select>
                        </form>
                    </td>
                    <td>{{ $row->created_at->format('d M Y') }} </td>
                  </tr>
                 @endforeach
                 @endif
                </table>
              </div>
              <!-- /.card-body -->
            </div>

          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Confirm</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p class="text-center h3">Are you sure want to delete Product? By deleting Product all related data can also be deleted and can not be retrived.</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">No</button>
              <a id="delete" href="" type="button" class="btn btn-outline-info" >Yes</a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
@include('admin::layouts.scripts')
<script>
    function deletemodal(id){
        $('#delete').attr('href',"{{url('admin/delete-product')}}/"+btoa(id));
        $('#modal-default').modal('show');
        return false;
    }
</script>
@endsection
