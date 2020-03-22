@extends('layouts.homework')

@section('header')
<form action="/ossz" method="get">
  <label>Keresés kezdete</label>
  <input type="datetime-local" name="kezdet" required>
    <label>Keresés vége</label>
  <input type="datetime-local" name="veg" required>
  <button type="submit">Összesít</button>
</form>
@endsection

@section('content')
<table>
    <tr>
        <th>Szerelő neve</th>
        <th>Munkák száma</th>
        <th>Dolgozott óra</th>
        <th>Munkaköltség</th>
    </tr>

    @foreach ($szerelo as $sorok)
    <tr>
       <td> {{$szerelo[$loop->index]->nev}}</td>
        <td>{{$szerelo[$loop->index]->db}}</td>
        <td>{{$szerelo[$loop->index]->ora}}</td>
        <td>{{$szerelo[$loop->index]->ar}}</td>
    </tr>

    @endforeach

</table>

<table>
    <tr>
        <th>Megrendelések száma (munkalapok)</th>
        <th>Kiadás</th>
        <th>Árrés</th>
        <th>Munkafolyamatokból származó bevétel</th>
        <th>Profit</th>
    </tr>

    @foreach ($rendeles as $sorok)
    <tr>
       <td> {{$rendeles[$loop->index]->db}}</td>
        <td>{{$rendeles[$loop->index]->koltseg}}</td>
        <td>{{$rendeles[$loop->index]->arres}}</td>
        <td>{{$munka[0]->ar}}</td>
        <td>{{$rendeles[0]->arres-$rendeles[$loop->index]->koltseg +$munka[$loop->index]->ar}}</td>
    </tr>

    @endforeach

</table>


@endsection
