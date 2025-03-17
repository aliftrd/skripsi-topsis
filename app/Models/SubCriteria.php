<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCriteria extends Model
{
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'criteria_code',
        'name',
        'weight'
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_code', 'code');
    }
}
