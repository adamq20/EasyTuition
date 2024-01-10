<?php

namespace App\Http\Controllers;

use App\Models\TagihanSpp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TagihanSppController extends Controller
{
    public function index()
    {
        return view('tagihan_spp.index');
    }

    public function tagihanSppJson()
    {
        $data = TagihanSpp::where(function($query) {
            if(auth()->user()->role == 'siswa') {
                $query->where('jurusan', '=', auth()->user()->siswa->jurusan)
                        ->where('kelas', '=', auth()->user()->siswa->kelas)
                        ->where(function($query) {
                            $query->whereDoesntHave('pembayaranSppMurid')
                                ->orWhereHas('pembayaranSppMurid', function($query) {
                                    $query->where('siswa_id', '!=', 1);
                                });
                        });
            }
        });

        return DataTables::of($data)
                            ->orderColumn('tanggal', function($query, $order) {
                                $query->orderBy('created_at', $order);
                            })
                            ->orderColumn('#', function($query, $order) {
                                $query->orderBy('id', $order);
                            })
                            ->orderColumn('kelas', function($query, $order) {
                                $query->orderBy('kelas', $order);
                            })
                            ->orderColumn('jurusan', function($query, $order) {
                                $query->orderBy('jurusan', $order);
                            })
                            ->orderColumn('total', function($query, $order) {
                                $query->orderBy('total', $order);
                            })
                            ->filterColumn('#', function($query, $key) {
                                $query->where('id', 'like', '%'.$key.'%');
                            })
                            ->filterColumn('kelas', function($query, $key) {
                                $query->where('kelas', 'like', '%'.$key.'%');
                            })
                            ->filterColumn('jurusan', function($query, $key) {
                                $query->where('jurusan', 'like', '%'.$key.'%');
                            })
                            ->filterColumn('total', function($query, $key) {
                                $query->where('total', 'like', '%'.$key.'%');
                            })
                            ->addColumn('#', function(TagihanSpp $t) {
                                return $t->id;
                            })
                            ->addColumn('kelas', function(TagihanSpp $t) {
                                return $t->kelas;
                            })
                            ->addColumn('jurusan', function(TagihanSpp $t) {
                                return $t->jurusan;
                            })
                            ->addColumn('total', function(TagihanSpp $t) {
                                return 'Rp '.number_format($t->total);
                            })
                            ->addColumn('aksi', function(TagihanSpp $t) {
                                if(auth()->user()->role == 'admin') {
                                    return '
                                        <a href="'.url('/tagihan/'.$t->id).'" class="btn btn-sm btn-info">Detail</a>
                                    ';
                                }

                                return '
                                        <a href="'.url('/pembayaran/c/'.$t->id).'" class="btn btn-sm btn-success">Bayar</a>
                                    ';
                            })
                            ->addColumn('tanggal', function(TagihanSpp $t) {
                                return $t->created_at;
                            })
                            ->rawColumns(['aksi'])
                            ->toJson();
    }

    public function create()
    {
        return view('tagihan_spp.create');
    }

    public function store(Request $request)
    {
        // store
        TagihanSpp::create([
            'id' => 'ts'.Str::random(8),
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'total' => str_replace(',', '', $request->total)
        ]);

        return redirect('/tagihan')->with('success', 'Data berhasil ditambah');
    }

    public function show(TagihanSpp $tagihan)
    {
        return view('tagihan_spp.show', compact('tagihan'));
    }

    public function edit(TagihanSpp $tagihan)
    {
        return view('tagihan_spp.edit', compact('tagihan'));
    }

    public function update(TagihanSpp $tagihan, Request $request)
    {
        // update
        $tagihan->update([
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'total' => str_replace(',', '', $request->total)
        ]);

        return redirect('/tagihan')->with('success', 'Data berhasil diubah');
    }

    public function destroy(TagihanSpp $tagihan)
    {
        $tagihan->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus!'
        ], 200);
    }
}
