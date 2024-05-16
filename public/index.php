<?php

require_once '../vendor/autoload.php';

use Core\Model\Lance;
use Core\Model\Leilao;
use Core\Model\User;
use Core\Service\Avaliador;

$leilao = new Leilao('Fiat 147 0Km');

$maria = new User('Maria');
$joao = new User('João');

$leilao->recebeLance(new Lance($joao, 2000));
$leilao->recebeLance(new Lance($maria, 2500));

$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);
$maiorValor = $leiloeiro->getMaiorValor();

dd($maiorValor);