<?php

$this->isLoggedIn();
$this->isAdministrator();

//Haetaan kaikki varaukset
$varaukset = Atomik_Db::findAll('varaukset', null, 'pvm DESC, alkuaika');