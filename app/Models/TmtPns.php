<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmtPns extends Model
{
    use HasFactory;
    protected $table = 'tmt_pns';
    protected $guarded = ['id'];

    public function tmt()
    {
        return $this->belongsTo(User::class, 'user_id'); // foreign key produk_id
    }
}
