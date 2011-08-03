<?php
$this->isLoggedIn(); //Kirjautumisen tarkastus
if($this->isAdministrator() == false){ //Vain isännöitsijä voi tehdä muille laskuja
    Atomik::flash('Ei käyttöoikeutta', 'error');
    Atomik::redirect ('index');
}

//Jos maksamattomia varauksia on ollut, niin haetaan käyttäjät, joita ei laskutettu
$haku = Atomik_Db::query("SELECT DISTINCT varaaja FROM varaukset WHERE maksettu = ?", array('false'));
$haku->execute();


//Haetaan laskut
$laskut = Atomik_Db::findAll('laskut');

while($user = $haku->fetch()){
    $users[] = $user[0];
}
if($user == null)
    $users[] = "";