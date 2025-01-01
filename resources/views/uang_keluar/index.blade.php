@extends('layouts.main')

@section('title', 'Uang Keluar')
@section('content')

<div class="container-fluid">
  <div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
      <div class="welcome-text">
        <span class="ml-1">Uang Keluar</span>
      </div>
    </div>
    <!-- <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                                                                                                            <ol class="breadcrumb">
                                                                                                                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                                                                                                                <li class="breadcrumb-item active"><a href="javascript:void(0)">Datatable</a></li>
                                                                                                            </ol>
                                                                                                        </div> -->
  </div>
  <!-- row -->
  @if (session('success'))
  <div class="alert alert-success alert-dismissible alert-alt solid fade show">
    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
      class="mdi mdi-close"></i></span>
    </button>
    <li><strong>Success!</strong> {{ session('success') }}. Silahkan Cek
      Kembali.</li>
  </div>
  @endif


  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Uang Keluar</h4>
        </div>
        <div class="card-body">
          <a href="{{ route('uang_keluar.create')}}" class="btn btn-primary">Create</a>
          <div class="table-responsive">
            <table id="table-uang" class="display nowrap text-dark" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Sumber Uang Keluar</th>
                  <th>Nominal</th>
                  <th>Tgl Keluar</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($uang_keluars as $uang)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $uang->sumber_uang_keluar}}</td>
                  <td>{{ $uang->nominal }}</td>
                  <td>{{ date('d-m-Y', strtotime($uang->tgl_keluar)) }}</td>

                  <td>
                    <form action="{{ route('uang_keluar.delete', $uang->id)}}" method="post">
                      @csrf
                      @method('delete')
                      <a href="{{ route('uang_keluar.edit', $uang->id)}}"
                        class="btn btn-warning">Edit</a>
                      <button class="btn btn-danger" onclick="return confirm('anda yakin hapus data ini')">Delete</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Sumber Uang Keluar</th>
                  <th>Nominal</th>
                  <th>Tgl Keluar</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  new DataTable('#table-uang', {
    responsive: true,
    rowReorder: {
      selector: 'td:nth-child(2)'
    }
  });
</script>
@endpush