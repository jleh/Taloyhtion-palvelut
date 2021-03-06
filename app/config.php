<?php

Atomik::set(array (
  'app' => 
  array (
    'layout' => '_layout',
    'default_action' => 'index',
    'views' => 
    array (
      'file_extension' => '.phtml',
    ),
  ),
  'atomik' => 
  array (
    'start_session' => true,
    'class_autoload' => true,
    'trigger' => 'action',
    'catch_errors' => true,
    'display_errors' => true,
    'debug' => false,
  ),
  'styles' => 
  array (
    0 => 'assets/css/main.css',
  ),
  'plugins' => 
  array (
  ),
  'scripts' => 
  array (
    0 => 'assets/js/libs/jquery.min.js',
  ),
));

Atomik::set('plugins/Db', array(
	'dsn' => 'pgsql:host=localhost;dbname=juusoleh',
	'username' => 'juusoleh',
	'password' => '3e88748e2956b8b8'
));
