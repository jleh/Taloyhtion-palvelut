<?php
//Hakee tunnit joina tila on varattuna tiettynä päivinä
function onkoVapaana($t, $p){
    $haku = Atomik_Db::query("SELECT * FROM varaukset WHERE tila = '$t' 
            AND pvm = '$p' ORDER BY alkuaika ASC");
    $haku->execute();

    //Tallennetaan jo varatut tunnit taulukkoon
    for($q = 0; $q < 25; $q++) //Taulukon alustus
        $vt[$q] = 0;

    while($tulos = $haku->fetchObject()){ //Taulukon täyttö
        for($i = $tulos->alkuaika; $i < $tulos->loppuaika; $i++)
            $vt[$i] = 1;
    }
    return($vt);
}
?>
