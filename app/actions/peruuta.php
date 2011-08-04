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

$haku = Atomik_Db::query("SELECT * FROM varaukset WHERE tunniste = ?", array($data['tunniste']));
$haku->execute();
$poistettava = $haku->fetch();

//Testit: Poistettava varaus on oma, varausta ei voi poistaa samana päivänä
if($poistettava['varaaja'] != Atomik::get('session/user') || $poistettava['pvm'] <= time()){
    Atomik::flash('Peruutus ei onnistunut', 'error');
    Atomik::redirect('index');
    return;
}


Atomik_Db::delete('varaukset', array('tunniste' => $data['tunniste']));
Atomik::redirect('index');