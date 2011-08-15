<?php
//Varauksen peruutus admin-puolella

$this->isLoggedIn();
$this->isAdministrator();

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

//Testit: varausta ei voi poistaa samana menneisyydestä, varaus on laskutettu
if($poistettava['pvm'] < time() || $poistettava['maksettu']){
    Atomik::flash('Peruutus ei onnistunut', 'error');
    Atomik::redirect('index');
    return;
}


Atomik_Db::delete('varaukset', array('tunniste' => $data['tunniste']));
Atomik::redirect('index');
Atomik::flash('Peruutit varauksen'.$data['tunniste']);