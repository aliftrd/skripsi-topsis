<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'name',
        'weight',
    ];

    public function subcriterias()
    {
        return $this->hasMany(SubCriteria::class, 'criteria_code', 'code');
    }
}
