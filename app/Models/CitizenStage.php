<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitizenStage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'citizen_code',
        'stage',
        'year',
    ];

    public function citizen()
    {
        return $this->belongsTo(Citizen::class, 'citizen_code', 'code');
    }
}
