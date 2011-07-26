<?php
//Tallennetaan varaus tietokantaan
$this->isLoggedIn(); //Kirjautumisen tarkastus

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
$maksu = Atomik::get('session/maksu');
$loppuaika = $data['loppu'];
$varaaja = Atomik::get('session/user');
$kesto = $loppuaika - $alku;

//Tarkastetaan että varaus yritetään tehdä sallitulle ajalle
$haku = Atomik_Db::query("SELECT * FROM tilat WHERE tila='$tila'");
$haku->execute();
$tulos = $haku->fetch();

if($alku < $tulos['alkuaika'] || $loppuaika > $tulos['loppuaika']) {
    Atomik::flash('Varausta ei voi tehdä kyseiselle ajalle', 'error');
    $url = Atomik::url('../tila', array('tila' => $tila));
    Atomik::redirect($url);
}

//Tarkastetaan vielä, ettei samaan aikaan ole muita varauksia
$varatut_tunnit = $this->onkoVapaana($tila, $pvm);

$onnistuu = true;
$h = $alku;
while($onnistuu == true && $h < $loppuaika){
    if($varatut_tunnit[$h] == 1)
        $onnistuu = false;
    $h++;
}

if($onnistuu == false){
    Atomik::flash("Varaus ei onnistu kyseiselle ajalle", "error");
    $url = Atomik::url('../tila', array('tila' => $tila));
    Atomik::redirect($url);
}
else{ //Tehdään varaus
    //Haetaan uusin varausnumero
    $haku = Atomik_Db::query('SELECT tunniste FROM varaukset ORDER BY tunniste DESC LIMIT 1');
    $haku->execute();
    $t = $haku->fetch();
    $tunniste = $t['tunniste'] + 1;
    
    $koodi = rand(1000, 9999); //Ovikoodi
    
    $tiedot = array(
        'tunniste' => $tunniste,
        'varaaja' => $varaaja,
        'tila' => $tila,
        'pvm' => $pvm,
        'alkuaika' => $alku,
        'loppuaika' => $loppuaika,
        'ovikoodi' => $koodi
    );
    
    Atomik_Db::insert('varaukset', $tiedot);
    
    //lasketaan vielä hinta
    $haku = Atomik_Db::query("SELECT hinta FROM tilat WHERE tila='$tila'");
    $haku->execute();
    $t = $haku->fetch();
    $hinta = $t['hinta'] * $kesto;
}