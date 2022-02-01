<?php

namespace App\Command;

use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CodespaceBlogInit2Command extends Command
{
    protected static $defaultName = 'codespace:blog:init2';
    protected static $defaultDescription = 'Add a short description for your command';

    private $entityManager;
    private $categoriaRepository;

    public function __construct(EntityManagerInterface $entityManager, CategoriaRepository $categoriaRepository)
    {
        $this->entityManager = $entityManager;
        $this->categoriaRepository = $categoriaRepository;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $categoria = $this->categoriaRepository->find(1);
        if ($categoria != null) {
            $categoria->setNombre('CATEGORIA CON NOMBRE MODIFICADO');
            $this->entityManager->flush();
            $output->writeln('modificado');
        }

        return Command::SUCCESS;
    }
}
