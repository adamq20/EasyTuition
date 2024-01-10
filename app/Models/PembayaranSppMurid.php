<?php

namespace App\Models;

use App\Models\Siswa;
use App\Models\TagihanSpp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembayaranSppMurid extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'pembayaran_spp_murid';
    protected $fillable = [
        'id',
        'tagihan_spp_id',
        'siswa_id',
        'total_tagihan_spp',
        'nis_siswa',
        'nama_siswa',
        'jk_siswa',
        'kelas_siswa',
        'jurusan_siswa',
        'telepon_siswa',
        'alamat_siswa',
        'bukti_pembayaran',
        'status',
        'tgl_bayar'
    ];
    protected $dates = [
        'created_at', 'tgl_bayar'
    ];

    public function tagihanSpp()
    {
        return $this->belongsTo(TagihanSpp::class, 'tagihan_spp_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
