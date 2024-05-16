<?php

require_once '../vendor/autoload.php';

use Core\SearchEngine\Engine;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

require_once '../vendor/autoload.php';

$client = new Client([
    'base_uri' => 'https://www.alura.com.br/',
]);

$crawler = new Crawler();
$engineSearch = new Engine($client, $crawler);

$courses = $engineSearch->search('cursos-online-programacao/php');

dd($courses);