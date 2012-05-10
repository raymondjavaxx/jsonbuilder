<?php

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . '/libraries');

spl_autoload_register(function ($class) {
	$file = str_replace('\\', '/', $class) . '.php';
	require_once $file;
});
