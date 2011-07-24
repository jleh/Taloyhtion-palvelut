<?php
if(Atomik::get('session/user') == '') //Kirjautumisen tarkastus
    Atomik::redirect('login');

$tilat = Atomik_Db::findAll('tilat', null, 'tila ASC');

?>
