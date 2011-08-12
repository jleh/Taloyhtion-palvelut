<?php
//Ei näytetä kirjautumista, jos jo kirjauduttu sisään
if(Atomik::get('session/user') != '')
    Atomik::redirect('index');
