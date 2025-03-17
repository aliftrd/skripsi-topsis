<?php

namespace App\Imports;

use App\Models\Citizen;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CitizensImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!array_filter($row)) {
            return null;
        }

        $citizen = Citizen::create([
            'code' => $row['code'],
            'nik' => $row['nik'],
            'name' => $row['nama'],
            'stage' => $row['tahap'],
            'province' => $row['provinsi'],
            'district' => $row['kabupaten'],
            'subdistrict' => $row['kecamatan'],
            'village' => $row['kelurahan'],
            'rt' => $row['rt'],
            'rw' => $row['rw'],
            'address' => $row['alamat'],
        ]);

        $criteriaData = Arr::except($row, ['code', 'nik', 'nama', 'tahap', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'alamat']);
        $subCriteriaData = [];

        foreach ($criteriaData as $criteriaCode => $subCriteriaCode) {
            $criteria = Criteria::where('code', $criteriaCode)->first();

            if ($criteria) {
                $subCriteria = SubCriteria::where('code', $subCriteriaCode)->where('criteria_code', $criteria->code)->first();

                if ($subCriteria) {
                    $subCriteriaData[] = $subCriteria->code;
                }
            }
        }

        $citizen->subCriterias()->sync($subCriteriaData);

        return $citizen;
    }
}
