<?php

if (Atomik::get('user') == '')
        return;

if (Atomik::get('user') != ''){
        Atomik::set('user', '');
        Atomik::flash('Kirjauduit ulos');
}

Atomik::redirect('index');
?>
