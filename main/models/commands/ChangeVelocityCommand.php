<?php

namespace main\models\commands;


use helpers\Math;
use main\models\exceptions\CommandException;

class ChangeVelocityCommand extends MacroCommand
{
    private float $newAngularVelocity;


    public function __construct(array $commandList, float $newAngularVelocity)
    {
        $this->newAngularVelocity = $newAngularVelocity;
        parent::__construct($commandList);

        if ($this->hasRotateCommand() === false) {
            throw new CommandException('Rotate command is required.');
        }
    }

    protected function afterExecute(Command $command): void
    {
        if ($command instanceof Rotate) {
            if (Math::isLowThenZero($this->newAngularVelocity)) {
                throw new CommandException('New angular velocity should be more than ' . Math::EPSILON . '.');
            }

            $command->getRotableAdapter()->setAngularVelocity($this->newAngularVelocity);
        }
        parent::beforeExecute($command);
    }

    private function hasRotateCommand(): bool
    {
        foreach ($this->getCommandList() as $command) {
            if ($command instanceof Rotate) {
                return true;
            }
        }
        return false;
    }
}