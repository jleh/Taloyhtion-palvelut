<?php

//if(!Atomik::has('request/tila')){
//	Atomik::flash('Parametri , puuttu')'error';
//}

$gTila = $_GET['tila'];

$haku = Atomik_Db::query("SELECT * FROM tilat WHERE tila = '$gTila'");
$haku->execute();
$tila = $haku->fetch();

$haku = Atomik_Db::query("Select * FROM varaukset WHERE tila = '$gTila'");
$haku->execute();
$varaus = $haku->fetch();

//Päivämäärmuodostus taulukkoon
for($d = 0; $d < 14; $d++)
   $date[$d] = date("d-m-Y" , mktime(0, 0, 0, date("m"), date("d")+$d, date("Y")));

?>