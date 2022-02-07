<?php

namespace main\models\commands;


use main\models\exceptions\CommandException;
use main\models\interfaces\Checkable;

class CheckFuel implements Command
{
    private Checkable $checkableAdapter;


    public function __construct(Checkable $checkableAdapter)
    {
        $this->checkableAdapter = $checkableAdapter;
    }

    public function execute(): void
    {
        if ($this->checkableAdapter->check() === false) {
            throw new CommandException('Fuel less than zero');
        }
    }
}