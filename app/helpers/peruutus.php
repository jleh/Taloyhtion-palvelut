<?php

//Ei näytetä linkkiä peruutuksen tekoon, jos se ei edes ole mahdollista

function peruutus($id) {
    $haku = Atomik_Db::query("SELECT * FROM varaukset WHERE tunniste = ?", array($id));
    $haku->execute();
    $varaus = $haku->fetch();
    
    if($varaus['maksettu'] || $varaus['pvm'] <= time())
        return;
    else
        return '<a href="'.Atomik::url('peruuta', array('tunniste' => $id)).'">
            Peruuta varaus</a>';
}