@extends('layouts.app')

@section('title', 'Tagihan')

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
                        <li class="breadcrumb-item active">Edit Data</li>
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
                    @if(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ url('/tagihan/u/'.$tagihan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="row">
                                    <div class="form-group col-lg-5">
                                        <label for="kelas">Kelas <span class="text-danger">*</span></label>
                                        <input type="text" name="kelas" id="kelas" class="form-control" value="{{ old('kelas') ? old('kelas') : $tagihan->kelas }}" required>
                                    </div>
                                    <div class="form-group col-lg-7">
                                        <label for="jurusan">Jurusan <span class="text-danger">*</span></label>
                                        <input type="text" name="jurusan" id="jurusan" class="form-control" value="{{ old('jurusan') ? old('jurusan') : $tagihan->jurusan }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="total">Total <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" name="total" id="total" class="form-control" value="{{ old('total') ? old('total') : $tagihan->total }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="{{ url('/tagihan') }}" class="btn btn-sm btn-light">Kembali</a>
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
    <script src="{{ asset('template/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // mask
            $('#total').inputmask('decimal', {
                rightAlign: false,
                groupSeparator: ','
            });

            $('#kelas').inputmask('decimal', {
                alias: 'numeric',
                allowMinus: false,
                digits: 2,
                max: 12,
                rightAlign: false
            });
        });
    </script>
@endpush
