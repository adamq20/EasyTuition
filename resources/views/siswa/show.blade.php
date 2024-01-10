@extends('layouts.app')

@section('title', 'Siswa')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Siswa</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/siswa') }}">Siswa</a></li>
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
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Pribadi</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item d-flex flex-wrap justify-content-between">
                                    <b>NIS</b> <a class="float-right">{{ $siswa->nis }}</a>
                                </li>
                                <li class="list-group-item d-flex flex-wrap justify-content-between">
                                    <b>Nama Lengkap</b> <a class="float-right">{{ $siswa->nama }}</a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between flex-wrap">
                                    <b>Jenis Kelamin</b> <a>{{ $siswa->jk == 'l' ? 'Laki-laki' : 'Perempuan' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Kelas</b> <a class="float-right">{{ $siswa->kelas }}</a>
                                </li>
                                <li class="list-group-item d-flex flex-wrap justify-content-between">
                                    <b>Jurusan</b> <a class="float-right">{{ $siswa->jurusan }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Telepon</b> <a class="float-right">{{ $siswa->telepon }}</a>
                                </li>
                                <li class="list-group-item d-flex flex-wrap flex-column">
                                    <b>Alamat</b> <a class="float-right mt-2">{{ $siswa->alamat }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Akun</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ $siswa->user->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Dibuat Pada</b> <a class="float-right">{{ $siswa->created_at->format('d/m/Y') }}</a>
                                </li>
                            </ul>
                            <a href="{{ url('/siswa') }}" class="btn btn-sm btn-light">Kembali</a>
                            <a href="{{ url('/siswa/e/'.$siswa->nis) }}" class="btn btn-sm btn-warning">Edit</a>
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
                            url: "{{ url('/siswa/d/'.$siswa->nis) }}",
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
                                    window.location = "{{ url('/siswa') }}";
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
