<?php
//Admin-osion etusivu
$this->isLoggedIn();
$this->testAdmin();

//Haetaan tulevat varaukset, jotka näytetään etusivulla
$aika = mktime(0, 0, 0);
$haku = Atomik_Db::query("SELECT * FROM varaukset WHERE pvm >= ? ORDER BY pvm, alkuaika", array($aika));
$haku->execute();

while($v = $haku->fetch())
    $varaukset[] = $v;