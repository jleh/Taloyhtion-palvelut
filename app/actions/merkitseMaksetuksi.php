<?php
//Merkitsee laskun maksetuksi

$this->isLoggedIn();
$this->isAdministrator();

$rule = array( //Parametrit
	'viite' => array('required' => true)
);

if(($data = Atomik::filter($_GET, $rule)) === false){ //Parametrien suodatus
    Atomik::flash('Virheellinen käyttäjä', 'error');
    Atomik::redirect('index');
    return;
}

Atomik_Db::update('laskut', array('maksettu' => 'true'), array('viite' => $data['viite']));
Atomik::redirect('laskut');