@extends('layouts.app')

@section('title', 'Pembayaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"></link>
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
                        <li class="breadcrumb-item active">Tambah Data</li>
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
                <div class="col-lg-6">
                    @if(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ url('/pembayaran/s') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-lg-5">
                                        <label for="tagihan_spp_id">ID Tagihan</label>
                                        <input type="text" name="tagihan_spp_id" id="tagihan_spp_id" class="form-control" value="{{ $tagihan->id }}" readonly>
                                    </div>
                                    <div class="form-group col-lg-7">
                                        <label for="total">Total</label>
                                        <input type="text" name="total" id="total" class="form-control" value="{{ 'Rp '.number_format($tagihan->total) }}" readonly>
                                        <input type="hidden" name="total_tagihan_spp" value="{{ $tagihan->total }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-5">
                                        <label for="bukti_pembayaran">Bukti Pembayaran <span class="text-danger">*</span></label>
                                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control-file" required>
                                        <small class="text-muted">Maks: 2Mb, Format: jpg, png</small>
                                        @if($errors->has('bukti_pembayaran'))
                                            <small class="text-danger d-block">{{ $errors->first('bukti_pembayaran') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-7">
                                        <label for="tgl_bayar">Tanggal Pembayaran <span class="text-danger">*</span></label>
                                        <input type="text" name="tgl_bayar" id="tgl_bayar" class="form-control" autocomplete="off" value="{{ old('tgl_bayar') }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="{{ url('/pembayaran') }}" class="btn btn-sm btn-light">Kembali</a>
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </form>
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
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // datepicker
            $('#tgl_bayar').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                language: 'id'
            });
        });
    </script>
@endpush
