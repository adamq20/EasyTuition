@extends('layouts.app')

@section('title', 'Tagihan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
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
                        <li class="breadcrumb-item"><a href="{{ url('/tagihan') }}">Tagihan</a></li>
                        <li class="breadcrumb-item active">Detail Data</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Detail Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>ID</b> <a class="float-right">{{ $tagihan->id }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Kelas</b> <a class="float-right">{{ $tagihan->kelas }}</a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between flex-wrap">
                                    <b>Jurusan</b> <a>{{ $tagihan->jurusan }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total</b> <a class="float-right">Rp {{ number_format($tagihan->total) }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Dibuat Pada</b> <a class="float-right">{{ $tagihan->created_at->format('d/m/Y') }}</a>
                                </li>
                            </ul>
                            <a href="{{ url('/tagihan') }}" class="btn btn-sm btn-light">Kembali</a>
                            <a href="{{ url('/tagihan/e/'.$tagihan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger btn-delete">Hapus</a>
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
    <script src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // delete
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Kamu yakin?',
                    text: "Data akan dihapus secara permanen",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    }).then((isConfirmed) => {
                    if (isConfirmed.value) {
                        $.ajax({
                            url: "{{ url('/tagihan/d/'.$tagihan->id) }}",
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    text: res.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    window.location = "{{ url('/tagihan') }}";
                                });
                            },
                            error: function(err) {
                                Swal.fire({
                                    icon: 'error',
                                    text: err.responseJSON.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        });
                    }
                })
            });
        });
    </script>
@endpush
