@extends('layouts.app')

@section('title', 'Siswa')

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
            <form action="{{ url('/siswa/s') }}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Data Pribadi</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nis">NIS <span class="text-danger">*</span></label>
                                    <input type="text" name="nis" id="nis" class="form-control {{ $errors->has('nis') ? 'is-invalid' : '' }}" value="{{ old('nis') }}" required>
                                    @if($errors->has('nis'))
                                        <div class="invalid-feedback">{{ $errors->first('nis') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="jk">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="jk" id="jk" class="form-control">
                                            <option value="l" {{ old('jk') == 'l' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="p" {{ old('jk') == 'p' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="kelas">Kelas <span class="text-danger">*</span></label>
                                        <input type="text" name="kelas" id="kelas" class="form-control" value="{{ old('kelas') }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-7">
                                        <label for="jurusan">Jurusan <span class="text-danger">*</span></label>
                                        <input type="text" name="jurusan" id="jurusan" class="form-control" value="{{ old('jurusan') }}" required>
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <label for="telepon">Telepon <span class="text-danger">*</span></label>
                                        <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon') }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" id="alamat" rows="5" class="form-control" required>{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Data Akun</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" required>
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" required>
                                    @if($errors->has('password'))
                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                    @else
                                        <small class="text-muted">Min: 8 karakter</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <a href="{{ url('/siswa') }}" class="btn btn-sm btn-light">Kembali</a>
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </form>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('scripts')
    <script src="{{ asset('template/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // mask
            $('#kelas').inputmask('decimal', {
                alias: 'numeric',
                allowMinus: false,
                digits: 2,
                max: 12,
                rightAlign: false
            });

            $('#nis').inputmask('decimal', {
                alias: 'numeric',
                allowMinus: false,
                rightAlign: false
            });

            $('#telepon').inputmask('9999-9999-9999');
        });
    </script>
@endpush
