<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotKriteria extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'bobot_kriteria';
    protected $guarded = ['id'];
}
