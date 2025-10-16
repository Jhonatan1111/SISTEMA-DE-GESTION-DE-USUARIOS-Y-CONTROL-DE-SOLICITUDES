@foreach ($listaCitologia as $citologia)
<tr>
    <td>{{ $citologia->codigo }}</td>
    <td>{{ $citologia->diagnostico }}</td>
    <td>{{ $citologia->macroscopico }}</td>
    <td>{{ $citologia->microscopico }}</td>
</tr>
@endforeach