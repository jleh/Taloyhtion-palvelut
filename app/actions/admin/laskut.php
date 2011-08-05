<?php
$this->isLoggedIn(); //Kirjautumisen tarkastus
$this->isAdministrator(); //Vain isännöitsijä voi tehdä muille laskuja

//Jos maksamattomia varauksia on ollut, niin haetaan käyttäjät, joita ei laskutettu
$haku = Atomik_Db::query("SELECT DISTINCT varaaja FROM varaukset WHERE maksettu = ?", array('false'));
$haku->execute();

while($laskutettava = $haku->fetch())
        $users[] = $laskutettava['varaaja'];

//Haetaan laskut
$haku = Atomik_Db::query('SELECT * FROM laskut ORDER BY viite DESC');
$haku->execute();

$laskuja = Atomik_Db::count('laskut');

while($lasku = $haku->fetch())
        $laskut[] = $lasku;


while($user = $haku->fetch()){
    $users[] = $user[0];
}
if($user == null)
    $users[] = "";