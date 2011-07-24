<?php
//Tallennetaan varaus tietokantaan
if(Atomik::get('session/user') == '') //Kirjautumisen tarkastus
    Atomik::redirect('login');

$rule = array(
    'loppu' => array('require' => true)
);

if(($data = Atomik::filter($_POST, $rule)) === false){ //Parametrien suodatus
	return;
}

//Muuttujat
$tila = Atomik::get('session/tila');
$pvm = Atomik::get('session/pvm');
$alku = Atomik::get('session/alkuaika');
$loppuaika = $data['loppu'];
$varaaja = Atomik::get('session/user');
$kesto = $loppuaika - $alku;

//Tarkastetaan vielä, että varaus voidaan tehdä
//Rakennetaan kysely
$lause = "SELECT COUNT(*) FROM varaukset WHERE tila='$tila' AND pvm='$pvm' AND
          alkuaika IN($alku";
for($i = $alku+1; $i < $loppuaika; $i++)
    $lause .= " ,$i";
$lause .= ") OR loppuaika IN(".($alku+1);

if($alku+2 < $loppuaika){ //Varattava vuoro yli 2h
    for($i = $alku+1; $i < $loppuaika; $i++)
        $lause .= " ,$i";
}
$lause .= ")";

$haku = Atomik_Db::query($lause);
$haku->execute();
$tulos = $haku->fetch();
if($tulos[0] != 0) {
    Atomik::flash('Varaus ei onnistu', 'error');
    Atomik::redirect('tila');
}
?>