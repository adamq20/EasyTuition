<?php

namespace App\Models;

use App\Models\User;
use App\Models\PembayaranSppMurid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $fillable = [
        'user_id',
        'nis',
        'nama',
        'jk',
        'kelas',
        'jurusan',
        'telepon',
        'alamat'
    ];
    protected $dates = [
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembayaranSppMurid()
    {
        return $this->hasMany(PembayaranSppMurid::class, 'siswa_id');
    }
}
