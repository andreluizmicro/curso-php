<?php

declare(strict_types=1);

namespace Unit\Core\Model;

use Core\Model\Lance;
use Core\Model\Leilao;
use Core\Model\User;
use DomainException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveReceberLancesRepetidos(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Usuário não pode propor 2 lances consecutivos');

        $leilao = new Leilao('Variante');
        $ana = new User('Ana');

        $leilao->recebeLance(new Lance($ana, 1000));
        $leilao->recebeLance(new Lance($ana, 1500));
    }

    #[DataProvider('gerarlances')]
    public function testLeilaoDeveReceberLances(int $qtdlance, Leilao $leilao, array $valores): void
    {
        static::assertCount($qtdlance, $leilao->getLances());

        foreach ($valores as $key => $valor) {
            static::assertEquals($valor, $leilao->getLances()[$key]->getValue());
        }
    }

    public function testLeilaoNaoDeveAceitarMaisQue5LancesPorUsuario(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Usuário não pode propor mais de 5 lances por leilão');

        $leilao = new Leilao('Brasília Amarela');

        $joao = new User('Joao');
        $maria = new User('Ana');

        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 3000));
        $leilao->recebeLance(new Lance($joao, 35000));
        $leilao->recebeLance(new Lance($maria, 4000));
        $leilao->recebeLance(new Lance($joao, 5500));
        $leilao->recebeLance(new Lance($maria, 6000));
        $leilao->recebeLance(new Lance($joao, 7000));
        $leilao->recebeLance(new Lance($maria, 9000));

        $leilao->recebeLance(new Lance($joao, 15000));

        static::assertCount(10, $leilao->getLances());
        static::assertEquals(9000, $leilao->getLances()[array_key_last($leilao->getLances())]->getValue());
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