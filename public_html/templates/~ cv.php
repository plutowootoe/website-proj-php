<?php

require_once('include/config.php'); // Include Twig autoloader

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates'); // Specify the directory containing your Twig template file
$twig = new \Twig\Environment($loader);

$template = $twig->load('cv.twig');
echo $template->render();
