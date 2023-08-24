<?php

use Sistema\Leilao\Model\Leilao;
use Sistema\Leilao\Model\Usuario;
use Sistema\Leilao\Model\Lance;
use Sistema\Leilao\Service\Avaliador;


require '../vendor/autoload.php';

$leilao = new Leilao('Fiat 147 0km');
$maria = new Usuario('Maria');
$joao = new Usuario('Joao');

$leilao->recebeLance(new Lance($joao, 2000));
$leilao->recebeLance(new Lance($maria, 2500));

$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();

echo $maiorValor;