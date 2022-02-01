<?php

namespace App\Command;

use App\Entity\Entrada;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\AsciiSlugger;

class CodespaceBlogCrearEntradaCommand extends Command
{
    protected static $defaultName = 'codespace:blog:crear-entrada';
    protected static $defaultDescription = 'Add a short description for your command';

    private $em;
    private $categoriaRepository;

    public function __construct(EntityManagerInterface $em, CategoriaRepository $categoriaRepository)
    {
        $this->em = $em;
        $this->categoriaRepository = $categoriaRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('titulo', InputArgument::OPTIONAL, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $categoria = $this->categoriaRepository->find(1);

        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($input->getArgument('titulo'));

        $entrada = new Entrada();
        $entrada->setTitulo($input->getArgument('titulo'));
        $entrada->setFecha(new \DateTime());
        $entrada->setEstado(1);
        $entrada->setResumen('RESUMEN');
        $entrada->setCategoria($categoria);
        $entrada->setSlug($slug);
        $this->em->persist($entrada);
        $this->em->flush();
        
        return Command::SUCCESS;
    }
}
