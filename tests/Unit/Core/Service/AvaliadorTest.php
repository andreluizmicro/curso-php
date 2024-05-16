<?php

declare(strict_types=1);

namespace Unit\Core\Service;

use Core\Model\Lance;
use Core\Model\Leilao;
use Core\Model\User;
use Core\Service\Avaliador;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    private Avaliador $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    #[DataProvider("leilaoEmOrderCrescente")]
    #[DataProvider("leilaoEmOrderDecrescente")]
    #[DataProvider("leilaoEmOrderAleatoria")]
    public function testAvaliadorDeveEncontrarMaioresValoresDelances(Leilao $leilao): void
    {
        $this->leiloeiro->avalia($leilao);
        self::assertEquals(2500, $this->leiloeiro->getMaiorValor());
    }

    #[DataProvider('leilaoEmOrderDecrescente')]
    public static function leilaoEmOrderCrescente()
    {
        $joao = new User('João');
        $maria = new User('Maria');
        $ana = new User('Ana');

        $leilao = new Leilao('Fiat 147 0Km');
        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            'ordem crescente' => [$leilao]
        ];
    }

    #[DataProvider('leilaoEmOrderDecrescente')]
    public static function leilaoEmOrderDecrescente()
    {
        $joao = new User('João');
        $maria = new User('Maria');
        $ana = new User('Ana');

        $leilao = new Leilao('Fiat 147 0Km');
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return [
            'ordem decrescente' => [$leilao]
        ];
    }

    #[DataProvider('leilaoEmOrderAleatoria')]
    public static function leilaoEmOrderAleatoria()
    {
        $joao = new User('João');
        $maria = new User('Maria');
        $ana = new User('Ana');

        $leilao = new Leilao('Fiat 147 0Km');
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($ana, 1700));

        return [
            'ordem aleatoria' => [$leilao]
        ];
    }
}