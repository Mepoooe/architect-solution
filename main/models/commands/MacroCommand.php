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
            $this->addCommand($command);
        }
    }

    public function execute(): void
    {
        foreach ($this->commandList as $key => $command) {
            $this->beforeExecute($command);
            $command->execute();
            $this->afterExecute($command);
            unset($this->commandList[$key]);
        }
    }

    public function addCommand(Command $command): void
    {
        $this->commandList[] = $command;
    }

    public function getCommandList(): array
    {
        return $this->commandList;
    }

    /**
     * @param Command[] $commandList
     */
    public function setCommandList(array $commandList): void
    {
        $this->commandList = $commandList;
    }

    public function clearCommands(): void
    {
        $this->commandList = [];
    }

    protected function beforeExecute(Command $command): void
    {
    }

    protected function afterExecute(Command $command): void
    {
    }
}