<?php
//Varauksen peruutus

$this->isLoggedIn();

$rule = array( //Parametrit
	'tunniste' => array('required' => true)
);

if(($data = Atomik::filter($_GET, $rule)) === false){ //Parametrien suodatus
    Atomik::flash('Peruutus ei onnistunut', 'error');
    Atomik::redirect('index');
    return;
}

//Haetaan poistettavan varauksen tiedot
$haku = Atomik_Db::query("SELECT * FROM varaukset WHERE tunniste = ?", array($data['tunniste']));
$haku->execute();
$poistettava = $haku->fetch();

//Testit: Poistettava varaus on oma, varausta ei voi poistaa samana päivänä, varaus on laskutettu
if($poistettava['varaaja'] != Atomik::get('session/user') || $poistettava['pvm'] <= time() 
        || $poistettava['maksettu']){
    Atomik::flash('Peruutus ei onnistunut', 'error');
    Atomik::redirect('index');
    return;
}


Atomik_Db::delete('varaukset', array('tunniste' => $data['tunniste']));
Atomik::redirect('index');