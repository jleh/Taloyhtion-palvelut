<?php

if (Atomik::get('user') == '') { //Ei kirjautunut sisään
                                 //eli kirjataan käyttäjä sisään
    $rule = array(
        'user' => array('required' => true),
        'pass' => array('required' => true));
    
    if(($data = Atomik::filter($_POST, $rule)) === false){ //Parametrien suodatus
	Atomik::flash('Virhe kirjautumistiedoissa', 'error');
        return;
    }
    
    $user = $data['user'];
    $pass = $data['pass'];
    
    //Tarkastetaan kirjautuminen tietokannasta
    $haku = Atomik_Db::query("SELECT COUNT(*) FROM users WHERE nimi='$user' 
            AND salasana = '$pass'");
    $haku->execute();
    
    $tulos = $haku->fetch();
    
    if($tulos['count'] != 1){
            Atomik::flash ('Nimi tai salasana virheellinen', 'error');
            return;
    }
    
    Atomik::set('user', $user);
}
?>
