<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeWork extends Controller
{
  public function index() {

    $adatok = DB::table('munkalap')
    ->select('*')
    ->paginate(10);

    return view('homework', ['html' => $adatok]);

  }
  public function lap($id) {

  $adatok = DB::select('SELECT * FROM munkalap WHERE lap_id = ?' , [$id]);
  $szerel = DB::select('SELECT * FROM szerelo');
  $alkatreszek = DB::select('SELECT nev FROM alkatresz');
  $beszallitok = DB::select('SELECT nev FROM beszallitok');
  $munkafolyamatok = DB::select('SELECT nev FROM munkafolyamatok');
  $rendeltszerelo = DB::select('SELECT DISTINCT szerelo.nev FROM szerelo INNER JOIN munka ON szerelo.szerelo_id = munka.szerelo_id WHERE munka.lap_id = ?', [$id]);
  $rendeltalkatresz = DB::select('SELECT DISTINCT alkatresz.nev, alkatresz.ar, alkat_rendel.db, beszallitok.arres FROM alkatresz
    INNER JOIN alkat_rendel ON (alkat_rendel.alkatresz_id = alkatresz.alkatresz_id)
    INNER JOIN beszallitok ON (beszallitok.beszall_id = alkat_rendel.beszall_id) WHERE alkat_rendel.lap_id = ?', [$id]);
  $rendeltfolyamatok = DB::select('SELECT DISTINCT munkafolyamatok.ar, munkafolyamatok.nev FROM munkafolyamatok INNER JOIN folyamat_rendel ON folyamat_rendel.folyamat_id = munkafolyamatok.folyamat_id WHERE folyamat_rendel.lap_id = ?', [$id]);
    $ch = curl_init("https://api.exchangeratesapi.io/latest");

    $headr = array();
    $headr[] = "Accept: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($ch);
    $data = json_decode($res, true);
    curl_close($ch);

    return view('munkalap')
    ->with('szerel',$szerel)
    ->with('html',$adatok)
    ->with('id',$id)
    ->with('szerelok',$rendeltszerelo)
    ->with('alkatresz',$alkatreszek)
    ->with('beszallitok',$beszallitok)
    ->with('rendeltalkatresz',$rendeltalkatresz)
    ->with('deviza', $data)
    ->with('munkafolyamatok', $munkafolyamatok)
    ->with('rendeltfolyamatok', $rendeltfolyamatok);
  }

  public function edit(Request $req) {

      DB::table('munkalap')
      ->where('lap_id', $req->id)
      ->update([
        'marka' => $req->marka,
        'típus' => $req->tipus,
        'km' => $req->km,
        'kezdet' => $req->kezdet,
        'veg' => $req->veg,
        'leiras' => $req->leiras,
      ]);


      return redirect('munkalap/'. $req->id);
  }

  public function add(Request $req) {

    //Lekérdezzük a munkalap legnagyobb azonosítóját, később ehhez hozzáadunk egyet.
    //Auto independent az azonosito oszlop az adatbázisban, de sajnos nem találtam más megoldást, másképpen nem szerette volna insertálni a sort.
      $id = DB::select('SELECT MAX(lap_id) as azonosito FROM munkalap');
    //Adatok insertálása.
      DB::table('munkalap')
      ->insert([
        'lap_id' => $id[0]->azonosito + 1,
        'marka' => $req->marka,
        'típus' => $req->tipus,
        'km' => $req->km,
        'kezdet' => $req->kezdet,
        'veg' => $req->veg,
        'leiras' => $req->leiras,
      ]);

      return redirect('homework');
  }

  public function addszerelo(Request $req) {

      $id = DB::select('SELECT MAX(munka_id) as azonosito FROM munka');
      $szereloid = DB::select('SELECT szerelo_id as azonosito FROM szerelo WHERE nev = ?', [$req->nevek]);

      DB::table('munka')
      ->insert([
        'munka_id' => $id[0]->azonosito + 1,
        'lap_id' => $req->id,
        'szerelo_id' => $szereloid[0]->azonosito,
      ]);

      return redirect('munkalap/'. $req->id);
  }

  public function addalkat(Request $req) {

      $id = DB::select('SELECT MAX(rendel_id) as azonosito FROM alkat_rendel');
      $alkatid = DB::select('SELECT alkatresz_id as azonosito FROM alkatresz WHERE nev = ?', [$req->nevek]);
      $beszallkeres = DB::select('SELECT beszall_id as azonosito FROM beszallitok WHERE nev = ? ', [$req->beszallito]);


      DB::table('alkat_rendel')
      ->insert([
        'rendel_id' => $id[0]->azonosito + 1,
        'alkatresz_id' => $alkatid[0]->azonosito,
        'db' => $req->darab,
        'lap_id' => $req->id,
        'beszall_id' => $beszallkeres[0]->azonosito,
      ]);

      return redirect('munkalap/'. $req->id);
  }
  public function addmunka(Request $req) {

      $id = DB::select('SELECT MAX(folyamat_rendel_id) as azonosito FROM folyamat_rendel');
      $folyamatkeres = DB::select('SELECT folyamat_id as azonosito FROM munkafolyamatok WHERE nev = ?', [$req->nevek]);

      DB::table('folyamat_rendel')
      ->insert([
        'folyamat_rendel_id' => $id[0]->azonosito + 1,
        'folyamat_id' => $folyamatkeres[0]->azonosito,
        'lap_id' => $req->id,
      ]);

      return redirect('munkalap/'. $req->id);
  }

  public function keres(Request $req) {

      $szerelo = DB::select('SELECT szerelo.nev, count(munka.szerelo_id) as db, TIME_FORMAT(SUM(munkalap.veg - munkalap.kezdet), "%H") as ora, sum(munkafolyamatok.ar) as ar
      FROM szerelo
      INNER JOIN munka ON (szerelo.szerelo_id = munka.szerelo_id)
      INNER JOIN munkalap ON (munkalap.lap_id = munka.lap_id)
      INNER JOIN folyamat_rendel ON (folyamat_rendel.lap_id = munkalap.lap_id)
      INNER JOIN munkafolyamatok ON (munkafolyamatok.folyamat_id = folyamat_rendel.folyamat_id)
      WHERE munkalap.kezdet >= ? AND munkalap.veg <= ?
      GROUP BY szerelo.nev', [$req->kezdet, $req->veg]);

      $rendeles = DB::select('SELECT COUNT(munkalap.lap_id) as db, SUM(alkatresz.ar)*alkat_rendel.db as koltseg, SUM(alkatresz.ar)*alkat_rendel.db*beszallitok.arres as arres
      FROM munkalap
      INNER JOIN alkat_rendel ON (alkat_rendel.lap_id = munkalap.lap_id)
      INNER JOIN alkatresz ON (alkatresz.alkatresz_id = alkat_rendel.alkatresz_id)
      INNER JOIN beszallitok ON (beszallitok.beszall_id = alkat_rendel.beszall_id)
      WHERE munkalap.kezdet >= ? AND munkalap.veg <= ?
      GROUP BY beszallitok.nev, db, arres', [$req->kezdet, $req->veg]);

      $munka = DB::select('SELECT SUM(munkafolyamatok.ar) as ar FROM munkafolyamatok INNER JOIN folyamat_rendel ON folyamat_rendel.folyamat_id = munkafolyamatok.folyamat_id');

    return view('ossz')
    ->with('szerelo',$szerelo)
    ->with('rendeles',$rendeles)
    ->with('munka',$munka);
  }
}
