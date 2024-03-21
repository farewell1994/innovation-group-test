<?php

namespace App\Command;

use App\Entity\Bonus\Bonus;
use App\Entity\Client\Client;
use App\Entity\ClientBonus\ClientBonus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:database:clear')]
class DatabaseClearCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->em->createQuery('DELETE FROM ' . Bonus::class)->execute();
        $this->em->createQuery('DELETE FROM ' . Client::class)->execute();
        $this->em->createQuery('DELETE FROM ' . ClientBonus::class)->execute();

        return Command::SUCCESS;
    }
}
