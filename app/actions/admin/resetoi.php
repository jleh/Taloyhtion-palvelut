<?php
//Isännöitsijä voi resetoida käyttäjän salasanan (asukas vaihtuu, salasana unohtunut...)
$this->isLoggedIn();
$this->isAdministrator();

$rule = array( //Parametrit
	'user' => array('required' => true)
);

if(($data = Atomik::filter($_GET, $rule)) === false){ //Parametrien suodatus
    Atomik::flash('Virhe', 'error');
    Atomik::redirect('admin/kayttajat');
    return;
}

//Generoidaan uusi salasana
$newPw = rand(1000, 9999);

Atomik_Db::set('users', array('salasana' => md5($newPw)),
        array('nimi' => $data['user']));