<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'nik',
        'name',
        'stage',
        'rt',
        'rw',
        'province',
        'district',
        'subdistrict',
        'village',
        'address'
    ];

    public function subCriterias()
    {
        return $this->belongsToMany(SubCriteria::class, 'citizen_has_criterias', 'citizen_code', 'sub_criteria_code')
            ->with('criteria');
    }
}
