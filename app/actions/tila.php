<?php
$this->isLoggedIn();

$rule = array( //Parametrit
	'tila' => array('required' => true)
);

if(($data = Atomik::filter($_GET, $rule)) === false){ //Parametrien suodatus
	Atomik::redirect('index');
        return;
}

$haku = Atomik_Db::query("SELECT * FROM tilat WHERE tila = ?", array($data['tila']));
$haku->execute();
$tila = $haku->fetch();

if($tila == null){
    Atomik::flash('Tilaa ei ole olemassa', 'error');
    Atomik::redirect('index');
}

$haku = Atomik_Db::query("SELECT * FROM varaukset WHERE tila = ?", array($data['tila']));
$haku->execute();
$varaus[] = 0;
while($v = $haku->fetch())
        $varaus[] = $v;

//Päivämäärmuodostus taulukkoon
for($d = 0; $d < 14; $d++)
   $date[$d] = date("d-m-Y" , mktime(0, 0, 0, date("m"), date("d")+$d, date("Y")));
