<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.index');
    }

    public function siswaJson()
    {
        $data = Siswa::query();

        return DataTables::of($data)
                            ->orderColumn('tanggal', function($query, $order) {
                                $query->orderBy('created_at', $order);
                            })
                            ->orderColumn('nis', function($query, $order) {
                                $query->orderBy('nis', $order);
                            })
                            ->orderColumn('kelas', function($query, $order) {
                                $query->orderBy('kelas', $order);
                            })
                            ->orderColumn('jurusan', function($query, $order) {
                                $query->orderBy('jurusan', $order);
                            })
                            ->orderColumn('nama', function($query, $order) {
                                $query->orderBy('nama', $order);
                            })
                            ->filterColumn('nis', function($query, $key) {
                                $query->where('nis', 'like', '%'.$key.'%');
                            })
                            ->filterColumn('kelas', function($query, $key) {
                                $query->where('kelas', 'like', '%'.$key.'%');
                            })
                            ->filterColumn('jurusan', function($query, $key) {
                                $query->where('jurusan', 'like', '%'.$key.'%');
                            })
                            ->filterColumn('nama', function($query, $key) {
                                $query->where('nama', 'like', '%'.$key.'%');
                            })
                            ->addColumn('nis', function(Siswa $s) {
                                return $s->nis;
                            })
                            ->addColumn('kelas', function(Siswa $s) {
                                return $s->kelas;
                            })
                            ->addColumn('jurusan', function(Siswa $s) {
                                return $s->jurusan;
                            })
                            ->addColumn('nama', function(Siswa $s) {
                                return $s->nama;
                            })
                            ->addColumn('aksi', function(Siswa $s) {
                                return '
                                    <a href="'.url('/siswa/'.$s->nis).'" class="btn btn-sm btn-info">Detail</a>
                                ';
                            })
                            ->addColumn('tanggal', function(Siswa $s) {
                                return $s->created_at;
                            })
                            ->rawColumns(['aksi'])
                            ->toJson();
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'unique:siswa,nis',
            'email' => 'unique:users,email',
            'password' => 'confirmed|min:8'
        ], [
            'nis.unique' => 'NIS sudah digunakan',
            'email.unique' => 'Email sudah digunakan',
            'password.confirmed' => 'Password tidak sama',
            'password.min' => 'Password kurang dari 8 karakter'
        ]);
        
        DB::transaction(function() use($request) {
            $user = User::create([
                'avatar' => $request->jk.'.png',
                'role' => 'siswa',
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
    
            Siswa::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'telepon' => str_replace('-', '', str_replace('_', '', $request->telepon)),
                'alamat' => $request->alamat
            ]);
        });

        return redirect('/siswa')->with('success', 'Data berhasil ditambah');
    }

    public function show($nis)
    {
        $siswa = Siswa::where('nis', '=', $nis)->firstOrFail();

        return view('siswa.show', compact('siswa'));
    }

    public function edit($nis)
    {
        $siswa = Siswa::where('nis', '=', $nis)->firstOrFail();

        return view('siswa.edit', compact('siswa'));
    }

    public function update($nis, Request $request)
    {
        $siswa = Siswa::where('nis', '=', $nis)->firstOrFail();

        $request->validate([
            'nis' => 'unique:siswa,nis,'.$siswa->id,
            'email' => 'unique:users,email,'.$siswa->user_id
        ], [
            'nis.unique' => 'NIS sudah digunakan',
            'email.unique' => 'Email sudah digunakan'
        ]);
        
        DB::transaction(function() use($siswa, $request) {
            User::find($siswa->user_id)->update([
                'avatar' => $request->jk.'.png',
                'email' => $request->email,
            ]);
    
            $siswa->update([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'telepon' => str_replace('-', '', str_replace('_', '', $request->telepon)),
                'alamat' => $request->alamat
            ]);
        });

        return redirect('/siswa')->with('success', 'Data berhasil diubah');
    }

    public function destroy($nis)
    {
        DB::transaction(function() use($nis) {
            $siswa = Siswa::where('nis', '=', $nis)->first();

            User::find($siswa->user_id)->delete();

            $siswa->delete();
        });
        
        return response()->json([
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}
