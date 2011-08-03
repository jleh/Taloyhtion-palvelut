<?php

function testAdmin() {
    $testi = Atomik_Db::count('users', array('nimi' => Atomik::get('session/user'),
        'admin' => 'true') );
    
    if($testi != 1){
        return false;
    }
    else
        return true;
}
