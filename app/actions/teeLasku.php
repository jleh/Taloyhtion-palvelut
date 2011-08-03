<?php

$rule = array( //Parametrit
	'user' => array('required' => true)
);

if(($data = Atomik::filter($_GET, $rule)) === false){ //Parametrien suodatus
	return;
}

//Katsotaan onko käyttäjällä maksamattomia varauksia
$haku = Atomik_Db::query("SELECT COUNT(*) FROM varaukset WHERE varaaja = ?
    AND maksettu=?", array($data['user'], 'false'));
$haku->execute();

$tulos = $haku->fetch();

if($tulos[0] == 0) { //Jos maksamattomia ei ole, ei tehdä laskuakaan
    $varaus = 0;
    Atomik::flash('Ei maksamattomia varauksia', 'error');
    Atomik::redirect('laskut');
    return;
}

//Jos maksamattomia varauksia on, haetaan ne
$haku = Atomik_Db::query("SELECT * FROM varaukset WHERE varaaja = ?
    AND maksettu = ?", array($data['user'], 'false'));
$haku->execute();
while($v = $haku->fetch())
        $varaus[] = $v;

foreach($varaus as $v) //Lasketaan laskun suuruus
    $yhteensa = $v['hinta'];

$suurin = count($varaus);
$viite = $varaus[$suurin-1]['tunniste']; //Viitenumeroksi tulee suurin maksamaton varausnumero

$teksti = ""; //Taulussa varattu tila lisähuomautuksille, jos sellaisille tulee tarvetta
$erapaiva = mktime(0, 0, 0, date("m"), date("d")+30, date("Y")); //Laitetaan eräpäivä kuukauden päähän

//Tallennetaan lasku kantaan
$tallennus = Atomik_Db::query("INSERT INTO laskut VALUES(?, ?, ?, ?, ?, ?)", 
        array($viite, 'false', $data['user'], $yhteensa, $erapaiva, $teksti));
$tallennus->execute();

//Asetetaan varaukset maksetuiksi
$tallennus = Atomik_Db::query("UPDATE varaukset SET maksettu = ? 
    WHERE varaaja = ?", array('true', $data['user']));
$tallennus->execute();

