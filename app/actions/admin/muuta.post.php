<?php
//Tilojen tietojen muutoksien tallennus

$this->isLoggedIn(); //Kirjautumisen tarkastus
$this->isAdministrator();

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

$data['alkuaika'] = (int)$data['alkuaika'];
$data['loppuaika'] = (int)$data['loppuaika'];

//Tarkastetaan syötteet
//Aika
if($data['alkuaika'] < 0 || !is_int($data['loppuaika']) < 0
        || $data['alkuaika'] > 23 || $data['loppuaika'] > 23){
    Atomik::flash('Virheellinen aika', 'error');
    Atomik::redirect('admin/tilat');
}

//Hinta
$data['hinta'] = (float)$data['hinta'];
if($data['hinta'] < 0) {
    Atomik::flash('Hinta ei voi olla negatiivinen', 'error');
    Atomik::redirect('admin/tilat');
}

$haku = Atomik_Db::query("UPDATE tilat SET alkuaika = ?, loppuaika = ?,
    hinta = ?, muuta = ? WHERE tila = ?",
        array($data['alkuaika'], $data['loppuaika'], $data['hinta'],
            $data['muuta'], $data['tila']));
$haku->execute();

Atomik::flash('Muutokset tehty', 'success');
Atomik::redirect('admin/tilat');
