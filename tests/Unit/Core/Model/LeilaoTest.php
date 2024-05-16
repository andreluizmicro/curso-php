<?php

declare(strict_types=1);

namespace Unit\Core\Model;

use Core\Model\Lance;
use Core\Model\Leilao;
use Core\Model\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveReceberLancesRepetidos(): void
    {
        $leilao = new Leilao('Variante');
        $ana = new User('Ana');

        $leilao->recebeLance(new Lance($ana, 1000));
        $leilao->recebeLance(new Lance($ana, 1500));

        static::assertCount(1, $leilao->getLances());
        static::assertEquals(1000, $leilao->getLances()[0]->getValue());
    }

    #[DataProvider('gerarlances')]
    public function testLeilaoDeveReceberLances(int $qtdlance, Leilao $leilao, array $valores): void
    {
        static::assertCount($qtdlance, $leilao->getLances());

        foreach ($valores as $key => $valor) {
            static::assertEquals($valor, $leilao->getLances()[$key]->getValue());
        }
    }

    public static function gerarlances(): array
    {
        $joao = new User('Joao');
        $maria = new User('Maria');

        $leilaoComUmLance = new Leilao('Fusca 1972 0Km');
        $leilaoComUmLance->recebeLance(new Lance($joao, 1000));

        $leilaoComDoisValores = new Leilao('Fiat 147 0Km');
        $leilaoComDoisValores->recebeLance(new Lance($joao, 1000));
        $leilaoComDoisValores->recebeLance(new Lance($maria, 2000));

        return [
            '1 - lances' => [1, $leilaoComUmLance, [1000]],
            '2 - lances' => [2, $leilaoComDoisValores, [1000, 2000]],
        ];
    }
}