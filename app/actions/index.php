<?php
$this->isLoggedIn(); //Kirjautumisen tarkastus

$tilat = Atomik_Db::findAll('tilat', null, 'tila ASC');

//Onko käyttäjällä varauksia
$varauksia = Atomik_Db::count('varaukset', array(array('varaaja' => Atomik::get('session/user'), 
    array('pvm >=' => mktime(0, 0, 0, date("m"), date("d"), date("Y"))))));
if($varauksia != 0) {
    $varaukset = Atomik_Db::query("SELECT * FROM varaukset WHERE varaaja =? 
        AND pvm >= ? ORDER BY pvm ASC", array(Atomik::get('session/user'), mktime(0, 0, 0, date("m"), date("d"), date("Y"))));
    $varaukset->execute();
    while($v = $varaukset->fetch())
            $varaus[] = $v;
}

//Ilmoitetaan käyttäjälle maksamattomista varauksista
$maksamattomat = Atomik_Db::count('varaukset', array('varaaja' => Atomik::get('session/user'),
        'maksettu' => 'false'));