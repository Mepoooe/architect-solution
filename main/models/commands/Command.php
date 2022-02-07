<?php

namespace main\models\commands;


interface Command
{
    public function execute(): void;
}