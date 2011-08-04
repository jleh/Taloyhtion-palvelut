<?php
$this->isLoggedIn(); //Kirjautumisen tarkastus

$tilat = Atomik_Db::findAll('tilat', null, 'tila ASC');

//Onko käyttäjällä varauksia
$varauksia = Atomik_Db::count('varaukset', array('varaaja' => Atomik::get('session/user')));
if($varauksia != 0) {
    $varaukset = Atomik_Db::query("SELECT * FROM varaukset WHERE varaaja =? 
        AND pvm >= ? ORDER BY pvm DESC", array(Atomik::get('session/user'), date("d-m-Y")));
    $varaukset->execute();
    while($v = $varaukset->fetch())
            $varaus[] = $v;
}

//Ilmoitetaan käyttäjälle maksamattomista varauksista
$maksamattomat = Atomik_Db::count('varaukset', array('varaaja' => Atomik::get('session/user'),
        'maksettu' => 'false'));