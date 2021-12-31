<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nis</th>
            <th>Nama</th>
            <th>Hadir</th>
            <th>Izin</th>
            <th>Sakit</th>
            <th>Absent</th>
            <th>Belum Presensi</th>
            <th>Total Presensi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $item)
        <tr>
            <td>{{$i+1}}</td>
            <td>{{$item->identity_number}}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->status_present_count}}</td>
            <td>{{ $item->status_permit_count}}</td>
            <td>{{ $item->status_sick_count}}</td>
            <td>{{ $item->status_absent_count}}</td>
            <td>{{ $item->status_pending_count}}</td>
            <td>{{ $item->record_count}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
