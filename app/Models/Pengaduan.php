<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengaduan extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'image', 'jenis_pengaduan', 'prioritas', 'status', 'rating', 'user_nik', 'user_id','id_petugas', 'responsivitas', 'komunikasi', 'sikap', 'waktu', 'pemahaman', 'desc_rating'
    ];
    
    protected $hidden = [
    
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_nik', 'nik');
    }

    public function details() {
        return $this->hasMany(Pengaduan::class, 'id', 'id');
    }

    public function phones() {
        return $this->belongsTo(User::class);
    }
    public function jenisPengaduan() {
        return $this->belongsTo(Pengaduan::class, 'jenis_pengaduan');
    }
    public function prioritas() {
        return $this->belongsTo(Pengaduan::class, 'prioritas');
    }
    public function tanggapans() {
    return $this->belongsTo(Pengaduan::class, 'id', 'id');
    }

    public function tanggapan() {
    return $this->hasOne(Tanggapan::class);
    }

    public function status() {
    return $this->belongsTo(Tanggapan::class, 'status_id','status');
    }

    public function petugas()
    {
        return $this->belongsTo(user::class, 'id_petugas', 'id');
    }
}