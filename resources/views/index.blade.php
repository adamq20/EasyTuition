@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
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
                @if(auth()->user()->role == 'admin')
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Siswa</span>
                                <span class="info-box-number">{{ $siswa }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-sticky-note"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tagihan</span>
                            <span class="info-box-number">{{ $tagihan }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Pembayaran</span>
                            <span class="info-box-number">{{ $pembayaran }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row">
                @if(auth()->user()->role == 'admin')
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pembayaran Terbaru</h3>
                            </div>
                            <div class="card-body">
                                @if(count($pembayaran_terbaru) > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            @foreach($pembayaran_terbaru as $d)
                                                <tr>
                                                    <td>{{ $d->id }}</td>
                                                    <td>{{ $d->nama_siswa }}</td>
                                                    <td>Rp {{ number_format($d->total_tagihan_spp) }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @else
                                    <small class="text-muted">Belum ada data</small>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tagihan Terbaru</h3>
                            </div>
                            <div class="card-body">
                                @if(count($tagihan_terbaru) > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            @foreach($tagihan_terbaru as $d)
                                                <tr>
                                                    <td>{{ $d->id }}</td>
                                                    <td>Rp {{ number_format($d->total) }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @else
                                    <small class="text-muted">Belum ada data</small>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
