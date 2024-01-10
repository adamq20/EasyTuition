<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Siswa;
use App\Models\TagihanSpp;
use Illuminate\Http\Request;
use App\Models\PembayaranSppMurid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PagesController extends Controller
{
    public function getIndex()
    {
        $tagihan = TagihanSpp::where(function($query) {
            if(auth()->user()->role == 'siswa') {
                $query->where('jurusan', '=', auth()->user()->siswa->jurusan)
                        ->where('kelas', '=', auth()->user()->siswa->kelas)
                        ->where(function($query) {
                            $query->whereDoesntHave('pembayaranSppMurid')
                                ->orWhereHas('pembayaranSppMurid', function($query) {
                                    $query->where('siswa_id', '!=', auth()->user()->siswa->id);
                                });
                        });
            }
        })->count();
        $siswa = DB::table('siswa')->count();
        $pembayaran = DB::table('pembayaran_spp_murid')->count();

        $pembayaran_terbaru = PembayaranSppMurid::take(5)->latest()->get();
        $tagihan_terbaru = TagihanSpp::where(function($query) {
            if(auth()->user()->role == 'siswa') {
                $query->where('jurusan', '=', auth()->user()->siswa->jurusan)
                        ->where('kelas', '=', auth()->user()->siswa->kelas)
                        ->where(function($query) {
                            $query->whereDoesntHave('pembayaranSppMurid')
                                ->orWhereHas('pembayaranSppMurid', function($query) {
                                    $query->where('siswa_id', '!=', auth()->user()->siswa->id);
                                });
                        });
            }
        })->take(5)->latest()->get();

        return view('index', compact('tagihan', 'siswa', 'pembayaran', 'pembayaran_terbaru', 'tagihan_terbaru'));
    }

    public function getProfile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'email' => 'unique:users,email,'.auth()->user()->id
        ], [
            'email.unique' => 'Email sudah dipakai'
        ]);

        User::find(auth()->user()->id)->update([
            'email' => $request->email
        ]);
        
        // siswa
        if(auth()->user()->role == 'siswa') {
            Siswa::find(auth()->user()->siswa->id)->update([
                'nama' => $request->nama,
                'telepon' => str_replace('_', '', str_replace('-', '', $request->telepon)),
                'alamat' => $request->alamat
            ]);
        } else {
            Admin::find(auth()->user()->admin->id)->update([
                'nama' => $request->nama,
                'telepon' => str_replace('_', '', str_replace('-', '', $request->telepon)),
            ]);
        }

        return redirect('/profile')->with('success', 'Profil berhasil diubah');
    }

    public function updatePassword(Request $request)
    {
        // check old password
        if(!Hash::check($request->old_password, auth()->user()->password)) {
            return response()->json([
                'message' => 'Password lama tidak sama!'
            ], 400);
        }

        User::find(auth()->user()->id)->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Password berhasil diubah'
        ], 200);
    }
}
