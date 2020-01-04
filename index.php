<?php
require 'flight/Flight.php';
require 'functions.php';
require 'jsonindent.php';

Flight::register('db', 'Database', array('dev'));
$json_data = file_get_contents("php://input");
Flight::set('json_data', $json_data );
Flight::route('/', function()
{
    echo 'hello world!';
});

Flight::route('GET /index.php/show', function()
{
	show();
});

Flight::route('POST /index.php/comment', 
function ()
{
	comment();		
});

Flight::route('POST /index.php', 
function ()
{
	newMovie();		
});

Flight::start();
?>
