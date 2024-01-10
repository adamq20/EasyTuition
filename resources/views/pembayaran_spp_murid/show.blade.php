@extends('layouts.app')

@section('title', 'Pembayaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pembayaran</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/pembayaran') }}">Pembayaran</a></li>
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
                @if(auth()->user()->role == 'admin')
                    <div class="col-lg-6">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">Data Siswa</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item d-flex flex-wrap justify-content-between">
                                        <b>NIS</b> <a class="float-right">{{ $pembayaran->nis_siswa }}</a>
                                    </li>
                                    <li class="list-group-item d-flex flex-wrap justify-content-between">
                                        <b>Nama Lengkap</b> <a class="float-right">{{ $pembayaran->nama_siswa }}</a>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between flex-wrap">
                                        <b>Jenis Kelamin</b> <a>{{ $pembayaran->jk_siswa == 'l' ? 'Laki-laki' : 'Perempuan' }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Kelas</b> <a class="float-right">{{ $pembayaran->kelas_siswa }}</a>
                                    </li>
                                    <li class="list-group-item d-flex flex-wrap justify-content-between">
                                        <b>Jurusan</b> <a class="float-right">{{ $pembayaran->jurusan_siswa }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Telepon</b> <a class="float-right">{{ $pembayaran->telepon_siswa }}</a>
                                    </li>
                                    <li class="list-group-item d-flex flex-wrap flex-column">
                                        <b>Alamat</b> <a class="float-right mt-2">{{ $pembayaran->alamat_siswa }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-lg-6">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Pembayaran</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item d-flex flex-wrap justify-content-between">
                                    <b>ID</b> <a class="float-right">{{ $pembayaran->id }}</a>
                                </li>
                                <li class="list-group-item d-flex flex-wrap justify-content-between">
                                    <b>Total</b> <a class="float-right">Rp {{ number_format($pembayaran->total_tagihan_spp) }}</a>
                                </li>
                                <li class="list-group-item d-flex flex-wrap justify-content-between">
                                    <b>Status</b> 
                                    <a class="float-right">
                                        @if($pembayaran->status == 'belum dikonfirmasi')
                                            <span class="badge badge-danger">{{ ucwords($pembayaran->status) }}</span>
                                        @else
                                            <span class="badge badge-success">{{ ucwords($pembayaran->status) }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Bukti Pembayaran</b> <a class="float-right" href="{{ asset('img/bukti_transfer/'.$pembayaran->bukti_pembayaran) }}" target="_blank">Lihat</a>
                                </li>
                                <li class="list-group-item d-flex flex-wrap justify-content-between">
                                    <b>Tanggal Pembayaran</b> <a class="float-right">{{ $pembayaran->tgl_bayar->format('d/m/Y') }}</a>
                                </li>
                            </ul>
                            <a href="{{ url('/pembayaran') }}" class="btn btn-sm btn-light">Kembali</a>
                            @if(auth()->user()->role == 'admin' && $pembayaran->status == 'belum dikonfirmasi')
                                <button type="button" class="btn btn-sm btn-success btn-konfirm">Konfirmasi</button>
                            @endif
                            @if(auth()->user()->role == 'siswa' && $pembayaran->status == 'belum dikonfirmasi')
                                <a href="#" class="btn btn-sm btn-danger btn-delete">Hapus</a>
                            @endif
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
            // set lunas
            @if(auth()->user()->role == 'admin')
                $('.btn-konfirm').on('click', function() {
                    Swal.fire({
                        title: 'Konfirmasi pembayaran?',
                        text: "Pembayaran ini akan kamu konfirmasi",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Konfirmasi',
                        cancelButtonText: 'Batal',
                        }).then((isConfirmed) => {
                        if (isConfirmed.value) {
                            $.ajax({
                                url: "{{ url('/pembayaran/confirm/'.$pembayaran->id) }}",
                                type: 'PATCH',
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
                                        location.reload();
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
                    });
                });
            @endif

            // delete
            @if(auth()->user()->role == 'siswa')
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
                                url: "{{ url('/pembayaran/d/'.$pembayaran->id) }}",
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
                                        window.location = "{{ url('/pembayaran') }}";
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
                    });
                });
            @endif
        });
    </script>
@endpush
