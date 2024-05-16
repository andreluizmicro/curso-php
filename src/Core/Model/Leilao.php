<?php

declare(strict_types=1);

namespace Core\Model;

class Leilao
{
    private array $lances;

    public function __construct(public string $description)
    {
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if (!empty($this->lances) && $this->isLastUser($lance)) {
            return;
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
}
