@extends('layouts.homework')

<script type="text/javascript">
/*function add() {
    var feltetel = @json($alkatresz);
    var feltetelek = "";
    for (var i = 0; i < feltetel.length; i++) {
        feltetelek += feltetel[i].nev + "|";
    }
    document.getElementsByClassName("add")[0].pattern = feltetelek;

}*/
</script>

@section('header')
                            <button class="btn active" onclick="filterSelection('feladat');">Módosítás</button>
                            <button class="btn active" onclick="filterSelection('szerelo');">Szerelő hozzárendelése</button>
                            <button class="btn active" onclick="filterSelection('alkatresz');">Alkatrész hozzárendelése</button>
                            <button class="btn active" onclick="filterSelection('munka');">Munkafolyamat hozzárendelése</button>
@endsection


@section('content')
                        <strong>{{$id}}. számú munkalap adatai:<br><br></strong>

                         <strong>Autó adatok:<br></strong><br>
                        <strong>Márka:</strong>
                          {{$html[0]->marka}}<br><br>

                          <strong>Típus:</strong>
                          {{$html[0]->típus}}<br><br>

                          <strong>Kilóméteróra állása:</strong>
                          {{$html[0]->km}}<br><br>

                          <strong>Munka kezdete:</strong>
                          {{$html[0]->kezdet}}<br><br>

                          <strong>Munka vége:</strong>
                          {{$html[0]->veg}}<br><br>

                          <strong>Leírás:</strong>
                          {{$html[0]->leiras}}<br><br>

                          <strong>Munkalaphoz rendelt szerelők:</strong>
                          @foreach ($szerelok as $film)
                          {{$szerelok[$loop->index]->nev}},
                          @endforeach
                          <br><br>
                        <strong>  Munkalaphoz rendelt alkatrészek:</strong>

                        <table>
                            <tr>
                                <th>Alkatrész neve</th>
                                <th>Darabszáma</th>
                                <th>Egységár</th>
                                <th>Ár</th>

                            </tr>
<?php $alkatszam = 0;?>
                            @foreach ($rendeltalkatresz as $film)
                            <?php $alkatszam = $alkatszam + $rendeltalkatresz[$loop->index]->ar*$rendeltalkatresz[$loop->index]->db*$rendeltalkatresz[$loop->index]->arres;?>


                            <tr>

                                <td>{{$rendeltalkatresz[$loop->index]->nev}}</td>
                                <td>{{$rendeltalkatresz[$loop->index]->db}}</td>
                                <td>{{round($rendeltalkatresz[$loop->index]->ar*$rendeltalkatresz[$loop->index]->arres/$deviza["rates"]["HUF"])}} EUR</td>
                                <td>{{round($rendeltalkatresz[$loop->index]->ar*$rendeltalkatresz[$loop->index]->db*$rendeltalkatresz[$loop->index]->arres/$deviza["rates"]["HUF"])}} EUR</td>

                            </tr>

                            @endforeach

                        </table>
                        <br><br>

  <strong>Alkatrészek összesen: <?php echo round($alkatszam/$deviza["rates"]["HUF"]); ?> EUR</strong>

<?php $munkaszam = 0; ?>
                          <br><br>
                        <strong>  Munkalaphoz rendelt munkafolyamatok:</strong>

                        <table>
                            <tr>
                                <th>Munkafolyamat neve</th>
                                <th>Ár</th>

                            </tr>

                            @foreach ($rendeltfolyamatok as $film)
                            <tr>
                              <?php $munkaszam = $munkaszam + $rendeltfolyamatok[$loop->index]->ar;?>
                                <td>{{$rendeltfolyamatok[$loop->index]->nev}}</td>
                                <td>{{round($rendeltfolyamatok[$loop->index]->ar/$deviza["rates"]["HUF"])}} EUR</td>

                            </tr>

                            @endforeach

                        </table>
                        <br>
                        <strong>Munkafolyamatok összesen: <?php echo round($munkaszam/$deviza["rates"]["HUF"]); ?> EUR</strong>

                        <br><br><br>
                        <strong>Végösszeg: <?php echo round(($munkaszam + $alkatszam)/$deviza["rates"]["HUF"]) ?> EUR</strong>



                          <br><br><br>

                            <!-- Új munkalap form -->
                            <form class="column feladat" action="/modosit" method="post">
                                @csrf
                                <label>Munkalap azonosítója</label>
                                <input class="remove" name="id" value="{{$id}}" required readonly>
                                <label>Márka</label>
                                <input name="marka" value="{{$html[0]->marka}}" required>
                                <label>Típus</label>
                                <input name="tipus" value="{{$html[0]->típus}}" required>
                                <label>Kilóméteróra állása</label>
                                <input type="number" value="{{$html[0]->km}}" name="km" required>
                                <label>Munka kezdete</label>
                                <input type="datetime-local" name="kezdet" required>
                                <label>Munka vége</label>
                                <input type="datetime-local" name="veg" required>
                                <label>Leírás</label>
                                <textarea name="leiras" required>{{$html[0]->leiras}}</textarea>

                                <button type="submit">Mentés</button>

                            </form>

                            <form class="column szerelo" action="/addszerelo" method="post">
                                @csrf
                                <label>Munkalap azonosítója</label>
                                <input class="remove" name="id" value="{{$id}}" required readonly>
                                <label>Szerelő kiválasztása</label>
                                <input class="add" list="nevek" name="nevek"  required>
                                <datalist id="nevek">
                                    @foreach ($szerel as $film)
                                    <option value="{{$szerel[$loop->index]->nev}}">
                                        @endforeach
                                </datalist>

                                <button onclick="add();" type="submit">Mentés</button>
                            </form>



                            <form class="column alkatresz" action="/addalkat" method="post">
                                @csrf
                                <label>Munkalap azonosítója</label>
                                <input class="remove" name="id" value="{{$id}}" required readonly>
                                <label>Alkatrész kiválasztása</label>
                                <input class="add" list="alkatresz" name="nevek"  required>
                                <datalist id="alkatresz">
                                    @foreach ($alkatresz as $film)
                                    <option value="{{$alkatresz[$loop->index]->nev}}">
                                        @endforeach
                                </datalist>
                                <label>Darabszám</label>
                                <input type="number" name="darab" required>
                                <label>Beszállító</label>
                                <input list="beszallitok" name="beszallito"  required>
                                <datalist id="beszallitok">
                                    @foreach ($beszallitok as $film)
                                    <option value="{{$beszallitok[$loop->index]->nev}}">
                                        @endforeach
                                </datalist>

                                <button onclick="add();" type="submit">Mentés</button>
                            </form>

                            <form class="column munka" action="/addmunka" method="post">
                                @csrf
                                <label>Munkalap azonosítója</label>
                                <input class="remove" name="id" value="{{$id}}" required readonly>
                                <label>Munkafolyamat kiválasztása</label>
                                <input class="add" list="munka" name="nevek"  required>
                                <datalist id="munka">
                                    @foreach ($munkafolyamatok as $film)
                                    <option value="{{$munkafolyamatok[$loop->index]->nev}}">
                                        @endforeach
                                </datalist>

                                <button onclick="add();" type="submit">Mentés</button>
                            </form>
@endsection
