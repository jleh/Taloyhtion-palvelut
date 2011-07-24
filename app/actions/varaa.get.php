<?php

$rule = array( //Parametrit
	'tila' => array('required' => true),
	'aika' => array('required' => true),
	'pvm' => array('required' => true)
);

if(($data = Atomik::filter($_GET, $rule)) === false){ //Parametrien suodatus
	return;
}

$tila = $data['tila'];
$pvm = $data['pvm'];
$aika = $data['aika'];

//Tallennetaan tiedot sessioon
Atomik::set('session/tila', $tila);
Atomik::set('session/pvm', $pvm);
Atomik::set('session/alkuaika', $aika);

//Haetaan aiemmat varauksamalle paivalle
$haku = Atomik_Db::query("SELECT * FROM varaukset WHERE tila = '$tila' 
        AND pvm = '$pvm'");
$haku->execute();

$c = 0;
while($tulos = $haku->fetchObject()){
	$varaukset[$c]['alku'] = $tulos->alkuaika;
	$varaukset[$c]['loppu'] = $tulos->loppuaika;
	$c++;
}

//Haetaan tilan tiedot
$haku = Atomik_Db::query("SELECT * FROM tilat WHERE tila='$tila'");
$haku->execute();

$vTila = $haku->fetchObject();

?>
