<?php

namespace main\models\commands;


use main\models\interfaces\Movable;

class MacroCommand implements Command
{
    /**
     * @var Command[]
     */
    private array $commandList;


    public function __construct(array $commandList)
    {
        foreach ($commandList as $command) {
            $this->setCommand($command);
        }
    }

    public function execute(): void
    {
        foreach ($this->commandList as $key => $command) {
            $command->execute();
            unset($this->commandList[$key]);
        }
    }

    public function setCommand(Command $command): void
    {
        $this->commandList[] = $command;
    }

    public function getCommandList(): array
    {
        return $this->commandList;
    }

    public function clearCommands(): void
    {
        $this->commandList = [];
    }
}