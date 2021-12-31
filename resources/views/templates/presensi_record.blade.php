<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nis</th>
            <th>Nama</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $item)
        <tr>
            <td>{{$i+1}}</td>
            <td>{{$item->student->identity_number}}</td>
            <td>{{ $item->student->name }}</td>
            <td>{{ $item->statusPresensi() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
