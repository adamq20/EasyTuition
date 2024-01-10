@extends('layouts.app')

@section('title', 'Tagihan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tagihan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Tagihan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Data Tagihan</h3>
                                @if(auth()->user()->role == 'admin')
                                    <a href="{{ url('/tagihan/c') }}" class="btn btn-sm btn-primary">Tambah Data</a>
                                @endif
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            @if(auth()->user()->role == 'admin')
                                                <th>Kelas</th>
                                                <th>Jurusan</th>
                                            @endif
                                            <th>Total</th>
                                            <th>Aksi</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('scripts')
    <script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // datatable
            $('table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: "{{ url('/tagihan/json') }}",
                    headers: {
                        'X-CSRF-TOKEN' : "{{ csrf_token() }}"
                    },
                    method: 'POST'
                },
                columns: [
                    { data: '#', name: '#' },
                    @if(auth()->user()->role == 'admin')
                        { data: 'kelas', name: 'kelas' },
                        { data: 'jurusan', name: 'jurusan' },
                    @endif
                    { data: 'total', name: 'total' },
                    { data: 'aksi', name: 'aksi' },
                    { data: 'tanggal', name: 'tanggal' }
                ],
                columnDefs: [
                    @if(auth()->user()->role == 'admin')
                        {
                            targets: 4,
                            orderable: false
                        },
                        {
                            targets: 5,
                            visible: false
                        }
                    @else
                        {
                            targets: 2,
                            orderable: false
                        },
                        {
                            targets: 3,
                            visible: false
                        }
                    @endif
                ],
                order: [["{{ auth()->user()->role == 'admin' ? 5 : 3 }}", 'desc']]
            });
        });
    </script>
@endpush
