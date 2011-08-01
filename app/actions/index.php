<?php
$this->isLoggedIn(); //Kirjautumisen tarkastus

$tilat = Atomik_Db::findAll('tilat', null, 'tila ASC');

$varaukset = Atomik_Db::find('varaukset', array('varaaja' => Atomik::get('session/user')));