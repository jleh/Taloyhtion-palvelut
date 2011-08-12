<?php
if(Atomik::get('session/user') != '')
    Atomik::redirect('index');
