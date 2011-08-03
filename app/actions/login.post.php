<?php

if (Atomik::get('session/user') == '') { //Ei kirjautunut sisään
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
    
    if($tulos['count'] != 1){//Käyttäjänimi-salasanaparia ei löydy
            Atomik::flash ('Nimi tai salasana virheellinen', 'error');
            Atomik::redirect('index');
            return;
    }
    
    Atomik::set('session/user', $user); //Nimi sessioon ja siirto etusivulle
    Atomik::redirect('index');
}
