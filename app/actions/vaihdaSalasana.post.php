<?php

$this->isLoggedIn();

$rule = array(
      'vanha' => array('required' => true),
      'uusi1' => array('required' => true),
      'uusi2' => array('required' => true)
);

if (($data = Atomik::filter($_POST, $rule)) === false) {
   Atomik::flash(A('app/filters/messages'), 'error');
   return;
}

$haku = Atomik_Db::query("SELECT salasana FROM users WHERE nimi = ?", 
        array(Atomik::get('session/user')));
$haku->execute();
$vanha = $haku->fetchObject();

if($data['uusi1'] == $data['uusi2'] && $vanha->salasana == md5($data['vanha'])){

    Atomik_Db::update('users', array('salasana' => md5($data['uusi1'])), 
            array('nimi' => Atomik::get('session/user')));
    Atomik::flash('Salasanan vaihto onnistui');
    Atomik::redirect('index');
}
else{
    Atomik::flash ('Salasanan vaihto ei onnistunut', 'error');
    Atomik::redirect('vaihdaSalasana');
}