<?php

namespace App\Imports;

use App\Models\Citizen;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CitizensImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $rowArray = $row->toArray();

            if (!array_filter($rowArray)) {
                continue;
            }

            $citizen = Citizen::updateOrCreate(
                ['code' => $rowArray['code']],
                [
                    'nik' => $rowArray['nik'],
                    'name' => $rowArray['nama'],
                    'province' => $rowArray['provinsi'],
                    'district' => $rowArray['kabupaten'],
                    'subdistrict' => $rowArray['kecamatan'],
                    'village' => $rowArray['kelurahan'],
                    'rt' => $rowArray['rt'] ?? null,
                    'rw' => $rowArray['rw'] ?? null,
                    'address' => $rowArray['alamat'],
                ]
            );

            if (!empty($rowArray['tahap'])) {
                [$stage, $year] = explode(':', $rowArray['tahap']) + [null, null];

                if ($stage && $year) {
                    $citizen->stages()->updateOrCreate(
                        ['citizen_code' => $citizen->code, 'stage' => $stage],
                        ['year' => $year]
                    );
                }
            }

            $criteriaData = Arr::except($rowArray, ['code', 'nik', 'nama', 'tahap', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'alamat']);
            $subCriteriaData = [];

            foreach ($criteriaData as $criteriaCode => $subCriteriaCode) {
                $criteria = Criteria::where('code', $criteriaCode)->first();

                if ($criteria) {
                    $subCriteria = SubCriteria::where('code', $subCriteriaCode)
                        ->where('criteria_code', $criteria->code)
                        ->first();

                    if ($subCriteria) {
                        $subCriteriaData[] = $subCriteria->code;
                    }
                }
            }

            $citizen->subCriterias()->sync($subCriteriaData);
        }
    }
}
