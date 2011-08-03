<?php
$this->isLoggedIn(); //Kirjautumisen tarkastus
if($this->isAdministrator() == false ) {
    Atomik::flash('Ei käyttöoikeutta', 'error');    
    Atomik::redirect('index');
}

$rule = array(
      'alkuaika' => array('required' => true),
      'loppuaika' => array('required' => true),
      'tila' => array('required' => true),
      'hinta' => array('required' => true),
      'muuta' => array('required' => false)
);

if (($data = Atomik::filter($_POST, $rule)) === false) {
   Atomik::flash(A('app/filters/messages'), 'error');
   return;
}

$tila = $data['tila'];
$muuta = $data['muuta'];

$haku = Atomik_Db::query("UPDATE tilat SET muuta='$muuta' WHERE tila='$tila'");
$haku->execute();

Atomik::flash('Muutokset tehty', 'success');
Atomik::redirect('testi');
