@extends('layouts.app')

@section('title', 'Profil')

@push('styles')
  <link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profil</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Profil</li>
            </ol>
          </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      @if(Session::has('success'))
        <div class="row">
          <div class="col-lg-12">
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-check"></i> Sukses!</h5>
              {{ Session::get('success') }}
            </div>
          </div>
        </div>
      @endif
      <div class="row">
        <div class="col-lg-3">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/avatar/'.auth()->user()->avatar) }}">
              </div>

              <h3 class="profile-username text-center">{{ auth()->user()->role == 'siswa' ? auth()->user()->siswa->nama : auth()->user()->admin->nama }}</h3>

              <p class="text-muted text-center">{{ auth()->user()->role == 'siswa' ? auth()->user()->siswa->nis : 'Admin' }}</p>

              @if(auth()->user()->role == 'siswa')
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Kelas</b> <a class="float-right">{{ auth()->user()->siswa->kelas }}</a>
                  </li>
                  <li class="list-group-item d-flex justify-content-between flex-wrap">
                    <b>Jurusan</b> <a class="float-right">{{ auth()->user()->siswa->jurusan }}</a>
                  </li>
                  <li class="list-group-item d-flex justify-content-between flex-wrap">
                    <b>Email</b> <a class="float-right">{{ auth()->user()->email }}</a>
                  </li>
                  <li class="list-group-item d-flex justify-content-between flex-wrap">
                    <b>Telepon</b> <a class="float-right">{{ auth()->user()->siswa->telepon }}</a>
                  </li>
                  <li class="list-group-item d-flex justify-content-between flex-column flex-wrap">
                    <b>Alamat</b> <a>{{ auth()->user()->siswa->alamat }}</a>
                  </li>
                </ul>
              @else
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item d-flex justify-content-between flex-wrap">
                    <b>Email</b> <a class="float-right">{{ auth()->user()->email }}</a>
                  </li>
                  <li class="list-group-item d-flex justify-content-between flex-wrap">
                    <b>Telepon</b> <a class="float-right">{{ auth()->user()->admin->telepon }}</a>
                  </li>
                </ul>
              @endif
            </div>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#edit-profile" data-toggle="tab">Edit Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="#ganti-password" data-toggle="tab">Ganti Password</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="edit-profile">
                  <form class="form-horizontal" action="{{ url('/profile') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group row">
                      <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" name="nama" class="form-control" id="nama" value="{{ auth()->user()->role == 'siswa' ? auth()->user()->siswa->nama : auth()->user()->admin->nama }}" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-8">
                        <div class="row">
                          <label for="email" class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" value="{{ auth()->user()->email }}" required>
                            @if($errors->has('email'))
                              <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                              </div>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="row">
                          <label for="telepon" class="col-sm-4 col-form-label">Telepon</label>
                          <div class="col-sm-8">
                            <input type="text" name="telepon" class="form-control" id="telepon" value="{{ auth()->user()->role == 'siswa' ? auth()->user()->siswa->telepon : auth()->user()->admin->telepon }}" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    @if(auth()->user()->role == 'siswa')
                      <div class="form-group row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="alamat" name="alamat" required>{{ auth()->user()->siswa->alamat }}</textarea>
                        </div>
                      </div>
                    @endif
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Simpan</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane" id="ganti-password">
                  <form action="{{ url('/u/password') }}">
                    @csrf
                    <div class="row">
                      <div class="form-group col-lg-4">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <small class="text-muted">Min: 8 karakter</small>
                      </div>
                      <div class="form-group col-lg-4">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                      </div>
                      <div class="form-group col-lg-4">
                        <label for="old_password">Password Lama</label>
                        <input type="password" name="old_password" id="old_password" class="form-control" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
@endsection

@push('scripts')
  <script src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('template/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      // mask
      $('#telepon').inputmask('9999-9999-9999');

      // update password
      $('#ganti-password form').on('submit', function(e) {
        e.preventDefault();

        const url = $(this).attr('action');
        const type = 'PATCH';
        const data = $(this).serialize();

        // validate
        if($(this).find('#password').val().length < 8) {
          Swal.fire({
            icon: 'error',
            text: 'Password terlalu singkat!',
            showConfirmButton: false,
            timer: 2000
          });

          return false;
        } else if($(this).find('#password').val() != $(this).find('#password_confirmation').val()) {
          Swal.fire({
            icon: 'error',
            text: 'Password baru tidak sama!',
            showConfirmButton: false,
            timer: 2000
          });

          return false;
        }                         

        $.ajax({
          url,
          type,
          data,
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
      });
    });
  </script>
@endpush