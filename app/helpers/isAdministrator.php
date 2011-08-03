<?php
//Tarkastaa onko käyttäjä isännöitsijä

function isAdministrator() {
    $testi = Atomik_Db::count('users', array('nimi' => Atomik::get('session/user'),
        'admin' => 'true') );
    
    if($testi != 1){
        Atomik::flash('Ei käyttöoikeutta', 'error');
        Atomik::redirect ('index');
        return false;
    }
    else
        return true;
}
