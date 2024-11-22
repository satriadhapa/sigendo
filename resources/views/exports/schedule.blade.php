<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Mata Kuliah</th>
            <th>Kelas</th>
            <th>Ruangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mappedSchedule as $index => $entry)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $entry['tanggal'] }}</td>
            <td>{{ $entry['jam'] }}</td>
            <td>{{ $entry['mata_kuliah'] }}</td>
            <td>{{ $entry['kelas'] }}</td>
            <td>{{ $entry['ruangan'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
