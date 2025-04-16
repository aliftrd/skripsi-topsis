<table>
    <thead>
        <tr>
            <th bgcolor="#5B9BD5" style="color: white;">{{ __('citizen.columns.code') }}</th>
            <th bgcolor="#5B9BD5" style="color: white;">{{ __('citizen.columns.name') }}</th>
            <th bgcolor="#5B9BD5" style="color: white;">{{ __('citizen.columns.nik') }}</th>
            <th bgcolor="#5B9BD5" style="color: white;">{{ __('citizen.columns.rt') }}</th>
            <th bgcolor="#5B9BD5" style="color: white;">{{ __('citizen.columns.rw') }}</th>
            <th bgcolor="#5B9BD5" style="color: white;">{{ __('citizen.columns.province') }}</th>
            <th bgcolor="#5B9BD5" style="color: white;">{{ __('citizen.columns.district') }}</th>
            <th bgcolor="#5B9BD5" style="color: white;">{{ __('citizen.columns.subdistrict') }}</th>
            <th bgcolor="#5B9BD5" style="color: white;">{{ __('citizen.columns.village') }}</th>
            <th bgcolor="#5B9BD5" style="color: white;">{{ __('citizen.columns.address') }}</th>
            <th bgcolor="#5B9BD5" style="color: white;">P</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($citizenRanks as $citizen)
            <tr>
                <td>{{ $citizen->code }}</td>
                <td>{{ $citizen->name }}</td>
                <td>{{ $citizen->nik }}</td>
                <td>{{ $citizen->rt }}</td>
                <td>{{ $citizen->rw }}</td>
                <td>{{ $citizen->province }}</td>
                <td>{{ $citizen->district }}</td>
                <td>{{ $citizen->subdistrict }}</td>
                <td>{{ $citizen->village }}</td>
                <td>{{ $citizen->address }}</td>
                <td>{{ $preferenceValue[$citizen->code] ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
