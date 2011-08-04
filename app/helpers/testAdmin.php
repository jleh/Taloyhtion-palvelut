<?php

function testAdmin() {
    $testi = Atomik_Db::count('users', array('nimi' => Atomik::get('session/user'),
        'admin' => 'true') );
    
    return $testi == 1;
}
