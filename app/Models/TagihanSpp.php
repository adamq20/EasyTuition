<?php

namespace App\Models;

use App\Models\PembayaranSppMurid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagihanSpp extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'tagihan_spp';
    protected $fillable = [
        'id',
        'jurusan',
        'kelas',
        'total',
    ];
    protected $dates = [
        'created_at'
    ];

    public function pembayaranSppMurid()
    {
        return $this->hasMany(PembayaranSppMurid::class, 'tagihan_spp_id');
    }
}
