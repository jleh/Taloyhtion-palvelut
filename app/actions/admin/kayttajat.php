<?php

//Haetaan käyttäjälista
$users = Atomik_Db::findAll('users', null, array('nimi'));