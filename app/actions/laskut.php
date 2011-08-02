<?php

//Haetaan maksamattomat varaukset
$haku = Atomik_Db::query("SELECT COUNT(DISTINCT varaaja) FROM varaukset WHERE maksettu = 'false'");
$haku->execute();
$luku = $haku->fetch();

if($luku > 0) { //Jos maksamattomia varauksia on ollut, niin haetaan käyttäjät, joita ei laskutettu
    $haku = Atomik_Db::query("SELECT DISTINCT varaaja FROM varaukset WHERE maksettu = 'false'");
    $haku->execute();
}

//Haetaan laskut
$laskut = Atomik_Db::findAll('laskut');

