<?php

$rule = array( //Parametrit
	'tila' => array('required' => true),
	'aika' => array('required' => true),
	'pvm' => array('required' => true)
);

if(($data = Atomik::filter($_GET, $rule)) === false){ //Parametrien suodatus
    Atomik::flash('Varaus ei onnistu', 'error');
    Atomik::redirect('index');
    return;
}

$tila = $data['tila'];
$pvm = $data['pvm'];
$aika = $data['aika'];

//Tallennetaan tiedot sessioon
Atomik::set('session/tila', $tila);
Atomik::set('session/pvm', $pvm);
Atomik::set('session/alkuaika', $aika);

$varatut_tunnit = $this->onkoVapaana($tila, $pvm); //Ei näytetä jo varattuja tunteja

//Haetaan tilan tiedot
$haku = Atomik_Db::query("SELECT * FROM tilat WHERE tila=?", array($tila));
$haku->execute();

$vTila = $haku->fetchObject();