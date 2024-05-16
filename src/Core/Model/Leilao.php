<?php

declare(strict_types=1);

namespace Core\Model;

use DomainException;

class Leilao
{
    private const TOTAL_MAXIMO_LANCE_POR_USUARIO = 5;
    private array $lances;

    public function __construct(public string $description)
    {
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if (!empty($this->lances) && $this->isLastUser($lance)) {
            throw new DomainException('Usuário não pode propor 2 lances consecutivos');
        }

        $usuario = $lance->getUser();
        $totalLancesPorUsuario = $this->quantidadeLancesPorUsuario($usuario);

        if ($totalLancesPorUsuario >= self::TOTAL_MAXIMO_LANCE_POR_USUARIO) {
            throw new DomainException('Usuário não pode propor mais de 5 lances por leilão');
        }

        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    /**
     * @param Lance $lance
     * @return bool
     */
    private function isLastUser(Lance $lance): bool
    {
        $ultimoLance = $this->lances[count($this->lances) - 1]->getUser();
        return $lance->getUser() === $ultimoLance;
    }

    /**
     * @param User $usuario
     * @return int
     */
    private function quantidadeLancesPorUsuario(User $usuario): int
    {
        return array_reduce(
            $this->lances,
            function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
                if ($lanceAtual->getUser() === $usuario) {
                    return $totalAcumulado + 1;
                }
                return $totalAcumulado;
            },
            0
        );
    }
}
