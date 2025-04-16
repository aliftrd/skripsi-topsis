<table>
    <thead>
        <tr>
            <th scope="col">{{ __('calculation.columns.no') }}</th>
            <th scope="col">{{ __('calculation.columns.name') }}</th>
            <th scope="col">P</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($citizenRanks as $citizen)
            <tr>
                <td>
                    {{ $loop->index + 1 }}
                </td>
                <td>{{ $citizen->name }}</td>
                <td>{{ $preferenceValue[$citizen->code] ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
