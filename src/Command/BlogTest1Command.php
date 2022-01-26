<?php

namespace App\Command;

use App\Entity\Espacio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BlogTest1Command extends Command
{
    protected static $defaultName = 'blog:test1';
    protected static $defaultDescription = 'Add a short description for your command';

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $espacio = new Espacio();
        $espacio->setNombre('NOMBRE');
        $this->em->persist($espacio);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
