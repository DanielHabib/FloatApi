<?php
require 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);

echo $twig->render('amp.html', array('name' => 'Fabien'));