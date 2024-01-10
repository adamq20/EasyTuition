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
            <form action="{{ url('/siswa/u/'.$siswa->nis) }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="row justify-content-center">
                    @if(Session::has('success'))
                        <div class="col-lg-12">
                            <div class="alert alert-success">
                                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                                {!! Session::get('success') !!}
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-6">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Data Pribadi</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nis">NIS <span class="text-danger">*</span></label>
                                    <input type="text" name="nis" id="nis" class="form-control {{ $errors->has('nis') ? 'is-invalid' : '' }}" value="{{ old('nis') ? old('nis') : $siswa->nis }}" required>
                                    @if($errors->has('nis'))
                                        <div class="invalid-feedback">{{ $errors->first('nis') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') ? old('nama') : $siswa->nama }}" required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="jk">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="jk" id="jk" class="form-control">
                                            @php
                                                $selected = '';
                                            @endphp
                                            @if(old('jk'))
                                                @php
                                                    $selected = old('jk');
                                                @endphp
                                            @else
                                                @php
                                                    $selected = $siswa->jk;
                                                @endphp
                                            @endif
                                            <option value="l" {{ $selected == 'l' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="p" {{ $selected == 'p' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="kelas">Kelas <span class="text-danger">*</span></label>
                                        <input type="text" name="kelas" id="kelas" class="form-control" value="{{ old('kelas') ? old('kelas') : $siswa->kelas }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-7">
                                        <label for="jurusan">Jurusan <span class="text-danger">*</span></label>
                                        <input type="text" name="jurusan" id="jurusan" class="form-control" value="{{ old('jurusan') ? old('jurusan') : $siswa->jurusan }}" required>
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <label for="telepon">Telepon <span class="text-danger">*</span></label>
                                        <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon') ? old('telepon') : $siswa->telepon }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" id="alamat" rows="5" class="form-control" required>{{ old('alamat') ? old('alamat') : $siswa->alamat }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Data Akun</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') ? old('email') : $siswa->user->email }}" required>
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <a href="{{ url('/siswa') }}" class="btn btn-sm btn-light">Kembali</a>
                                    <a href="#" data-toggle="modal" data-target="#modalPassword" class="btn btn-sm btn-warning">Reset Password</a>
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

    <!-- Modal -->
    <div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <form action="{{ url('/users/reset-password/'.$siswa->user_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <p>Apakah kamu yakin?</p>
                            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success btn-sm">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
