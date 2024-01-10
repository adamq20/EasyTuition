<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TagihanSpp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\PembayaranSppMurid;

class PembayaranSppMuridController extends Controller
{
    public function index()
    {
        return view('pembayaran_spp_murid.index');
    }

    public function pembayaranSppMuridJson()
    {
        $data = PembayaranSppMurid::where(function($query) {
            if(auth()->user()->role == 'siswa') {
                $query->where('siswa_id', '=', auth()->user()->siswa->id);
            }
        });

        return DataTables::of($data)
                        ->filterColumn('#', function($query, $key) {
                            $query->where('id', 'like', '%'.$key.'%');
                        })
                        ->filterColumn('nis', function($query, $key) {
                            $query->where('nis_siswa', 'like', '%'.$key.'%');
                        })
                        ->filterColumn('nama', function($query, $key) {
                            $query->where('nama_siswa', 'like', '%'.$key.'%');
                        })
                        ->filterColumn('kelas', function($query, $key) {
                            $query->where('kelas_siswa', 'like', '%'.$key.'%');
                        })
                        ->filterColumn('jurusan', function($query, $key) {
                            $query->where('jurusan_siswa', 'like', '%'.$key.'%');
                        })
                        ->filterColumn('total', function($query, $key) {
                            $query->where('total_tagihan_spp', 'like', '%'.$key.'%');
                        })
                        ->filterColumn('status', function($query, $key) {
                            $query->where('status', 'like', '%'.$key.'%');
                        })
                        ->orderColumn('#', function($query, $order) {
                            $query->orderBy('id', $order);
                        })
                        ->orderColumn('nis', function($query, $order) {
                            $query->orderBy('nis_siswa', $order);
                        })
                        ->orderColumn('nama', function($query, $order) {
                            $query->orderBy('nama_siswa', $order);
                        })
                        ->orderColumn('kelas', function($query, $order) {
                            $query->orderBy('kelas_siswa', $order);
                        })
                        ->orderColumn('jurusan', function($query, $order) {
                            $query->orderBy('jurusan_siswa', $order);
                        })
                        ->orderColumn('total', function($query, $order) {
                            $query->orderBy('total_tagihan_spp', $order);
                        })
                        ->orderColumn('status', function($query, $order) {
                            $query->orderBy('status', $order);
                        })
                        ->orderColumn('tanggal', function($query, $order) {
                            $query->orderBy('created_at', $order);
                        })
                        ->addColumn('#', function(PembayaranSppMurid $p) {
                            return $p->id;
                        })
                        ->addColumn('nis', function(PembayaranSppMurid $p) {
                            return $p->nis_siswa;
                        })
                        ->addColumn('nama', function(PembayaranSppMurid $p) {
                            return $p->nama_siswa;
                        })
                        ->addColumn('kelas', function(PembayaranSppMurid $p) {
                            return $p->kelas_siswa;
                        })
                        ->addColumn('jurusan', function(PembayaranSppMurid $p) {
                            return $p->jurusan_siswa;
                        })
                        ->addColumn('total', function(PembayaranSppMurid $p) {
                            return 'Rp '.number_format($p->total_tagihan_spp);
                        })
                        ->addColumn('status', function(PembayaranSppMurid $p) {
                            if($p->status == 'belum dikonfirmasi') {
                               return '<span class="badge badge-danger">'.ucwords($p->status).'</span>';
                            }

                            return '<span class="badge badge-success">'.ucwords($p->status).'</span>';
                        })
                        ->addColumn('aksi', function(PembayaranSppMurid $p) {
                            return '
                                <a href="'.url('/pembayaran/'.$p->id).'" class="btn btn-sm btn-info">Detail</a>
                            ';
                        })
                        ->addColumn('tanggal', function(PembayaranSppMurid $p) {
                            return $p->created_at;
                        })
                        ->rawColumns(['aksi', 'status'])
                        ->toJson();
    }

    public function create(TagihanSpp $tagihan)
    {
        return view('pembayaran_spp_murid.create', compact('tagihan'));
    }

    public function store(Request $request)
    {
        // check apakah pembayaran tagihan ini sudah pernah diinput ?
        $check = PembayaranSppMurid::where('tagihan_spp_id', '=', $request->tagihan_spp_id)
                                    ->where('siswa_id', '=', auth()->user()->siswa->id)
                                    ->count();

        if($check > 0) {
            return redirect()->back()->with('error', 'Pembayaran sudah ada!')->withInput();
        }

        $request->validate([
            'bukti_pembayaran' => 'max:2048|mimes:jpeg,jpg,png'
        ], [
            'bukti_pembayaran.max' => 'Ukuran file terlalu besar',
            'bukti_pembayaran.mimes' => 'Format file salah',
            'bukti_pembayaran.uploaded' => 'Ukuran file terlalu besar'
        ]);

        // upload bukti pembayaran
        $id = 'psm'.Str::random(8);

        $photo = $request->bukti_pembayaran;
        $photo_name = $id.'.'.$photo->getClientOriginalExtension();

        $this->uploadPhoto($photo, $photo_name);

        PembayaranSppMurid::create([
            'id' => $id,
            'tagihan_spp_id' => $request->tagihan_spp_id,
            'siswa_id' => auth()->user()->siswa->id,
            'total_tagihan_spp' => $request->total_tagihan_spp,
            'nis_siswa' => auth()->user()->siswa->nis,
            'nama_siswa' => auth()->user()->siswa->nama,
            'jk_siswa' => auth()->user()->siswa->jk,
            'kelas_siswa' => auth()->user()->siswa->kelas,
            'jurusan_siswa' => auth()->user()->siswa->jurusan,
            'telepon_siswa' => auth()->user()->siswa->telepon,
            'alamat_siswa' => auth()->user()->siswa->alamat,
            'bukti_pembayaran' => $photo_name,
            'status' => 'belum dikonfirmasi',
            'tgl_bayar' => Carbon::createFromFormat('d/m/Y', $request->tgl_bayar)->format('Y-m-d')
        ]);

        return redirect('/pembayaran')->with('success', 'Data berhasil ditambah');
    }

    public function show(PembayaranSppMurid $pembayaran)
    {
        return view('pembayaran_spp_murid.show', compact('pembayaran')); 
    }

    public function confirm(PembayaranSppMurid $pembayaran)
    {
        $pembayaran->update([
            'status' => 'sudah dikonfirmasi'
        ]);

        return response()->json([
            'message' => 'Pembayaran berhasil dikonfirmasi'
        ], 200);
    }

    public function destroy(PembayaranSppMurid $pembayaran)
    {
        // cek apakah pembayaran sudah di konfirmasi ?
        if($pembayaran->status == 'sudah dikonfirmasi') {
            return response()->json([
                'message' => 'Pembayaran sudah dikonfirmasi, silahkan refresh'
            ], 400);
        }

        unlink(public_path('img/bukti_transfer/'.$pembayaran->bukti_pembayaran));

        $pembayaran->delete();

        return response()->json([
            'message' => 'Pembayaran berhasil dihapus'
        ], 200);
    }

    private function uploadPhoto($photo, $photo_name)
    {
        $photo->move(public_path('img/bukti_transfer'), $photo_name);
    }
}
