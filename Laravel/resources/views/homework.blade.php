@extends('layouts.homework')

@section('header')
                            <button class="btn active" onclick="filterSelection('feladat');">Új munkalap</button>
@endsection



@section('content')
                          <table>
                              <tr>
                                  <th>Azonosító</th>
                                  <th>Márka</th>
                                  <th>Típus</th>
                                  <th>Kilóméteróra állása</th>
                                  <th>Leírás</th>
                              </tr>
                              <!-- Táblázat feltöltése -->
                              @foreach ($html as $sorok)
                              <tr>
                                 <td><a href="/munkalap/{{$html[$loop->index]->lap_id}}"> {{$html[$loop->index]->lap_id}}</a></td>
                                  <td>{{$html[$loop->index]->marka}}</td>
                                  <td>{{$html[$loop->index]->típus}}</td>
                                  <td>{{$html[$loop->index]->km}}</td>
                                  <td>{{$html[$loop->index]->leiras}}</td>
                              </tr>

                              @endforeach

                          </table>

                          {{ $html->appends(request()->except('page'))->links() }}


                            <!-- Új munkalap form -->
                            <form id="action" class="column feladat" action="/add" method="post">
                                @csrf
                                <label>Márka</label>
                                <input name="marka" required>
                                <label>Típus</label>
                                <input name="tipus" required>
                                <label>Kilóméteróra állása</label>
                                <input type="number" name="km" required>
                                <label>Munka kezdete</label>
                                <input type="datetime-local" name="kezdet" required>
                                <label>Munka vége</label>
                                <input type="datetime-local" name="veg" required>


                                <label>Leírás</label>
                                <textarea name="leiras" required></textarea>

                                <button type="submit">Mentés</button>
                            </form>
                            </table>

                                <!-- Keresés form -->
                            </form>
                            <form class="column keres" action="/keres" method="get">

                                <label>Ügyintéző neve:</label>
                                <br>
                                <input name="nev">
                                <label>Leírás</label>
                                <input name="leiras">
                                <label>Létrehozás dátuma</label>
                                <input type="date" name="datum">
                                <button type="submit">Keresés</button>
                            </form>
@endsection
