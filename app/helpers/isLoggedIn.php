<?php
//Tarkastaa onko käyttäjä kirjautunut sisään

function isLoggedIn()
{
    if(Atomik::get('session/user') == ''){
            Atomik::redirect ('login');
            return false;
    }
    else{
        $user = Atomik::get('session/user');
        $haku = Atomik_Db::count('users', array('nimi' => $user));
        if($haku != 1){
            Atomik::redirect ('login');
            return false;
        }
        else
            return true;
    }
}
