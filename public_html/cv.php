<?php

require_once 'include/config.php'; // Include Twig autoloader

$data = [
    'tree' => [
        'title' => 'Common hawthorn',
        'latinTitle' => 'Crataegus monogyna',
        'image' => 'images/crataegus-monogyna.jpg',
        'description' => 'Common hawthorn (Crataegus monogyna) is a flowering tree that is actually part of the rose family.'
    ],
    'tree2' => [
        'title2' => 'Oak Tree',
        'latinTitle2' => 'Crataegus monogyna',
        'image2' => 'images/oak',
        'description2' => 'The Oak tree is known for its tree-ness.'
    ]
];

$template = $twig->load('cv.twig');
echo $template->render($data);

date_default_timezone_set('Europe/Paris');
