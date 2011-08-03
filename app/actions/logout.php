<?php

if (Atomik::get('session/user') == '')
        Atomik::redirect ('index');
        return;

if (Atomik::get('session/user') != ''){
        Atomik::set('session/user', '');
        Atomik::flash('Kirjauduit ulos');
}

Atomik::redirect('index');

