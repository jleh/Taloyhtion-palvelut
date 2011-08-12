<?php

//Haetaan tilat tietokannasta
$tilat = Atomik_Db::findAll('tilat', null, array('tila'));