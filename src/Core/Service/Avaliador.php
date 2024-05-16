<?php

declare(strict_types=1);

namespace Core\Service;

use Core\Model\Lance;
use Core\Model\Leilao;

class Avaliador
{
    private float $maiorValor = -INF;
    private float $menorValor = INF;
    private array $maioresLances;

    public function avalia(Leilao $leilao): void
    {
        foreach ($leilao->getLances() as $lance) {
            if ($lance->getValue() > $this->maiorValor) {
                $this->maiorValor = $lance->getValue();
            }

            if ($lance->getValue() < $this->menorValor) {
                $this->menorValor = $lance->getValue();
            }
        }

        $lances = $leilao->getLances();
        usort($lances, function (Lance $lance1, Lance $lance2) {
            return $lance2->getValue() - $lance1->getValue();
        });
        $this->maioresLances = array_slice($lances, 0, 3);
    }

    public function getMaiorValor(): float
    {
        return $this->maiorValor;
    }

    public function getMenorValor(): float
    {
        return $this->menorValor;
    }

    public function getMaioresLances(): array
    {
        return $this->maioresLances;
    }
}
