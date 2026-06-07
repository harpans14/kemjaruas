<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    use HasFactory;

    protected $table = 'setoran';

    protected $fillable = [
        'user_id',
        'jenis_sampah',
        'berat',
        'tanggal_setoran',
        'status',
        'bukti_foto',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'berat' => 'decimal:2',
            'tanggal_setoran' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
