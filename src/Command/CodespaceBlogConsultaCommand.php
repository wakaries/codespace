<?php

namespace App\Command;

use App\Repository\CategoriaRepository;
use App\Repository\EntradaRepository;
use App\Repository\EspacioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CodespaceBlogConsultaCommand extends Command
{
    protected static $defaultName = 'codespace:blog:consulta';
    protected static $defaultDescription = 'Add a short description for your command';

    private $espacioRepository;
    private $categoriaRepository;
    private $entradaRepository;
    private $em;

    public function __construct(EspacioRepository $espacioRepository, CategoriaRepository $categoriaRepository, EntradaRepository $entradaRepository, EntityManagerInterface $em)
    {
        $this->espacioRepository = $espacioRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->entradaRepository = $entradaRepository;
        $this->em = $em;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entradas = $this->entradaRepository->findAll();
        foreach ($entradas as $entrada) {
            $output->writeln($entrada->getSlug() . ' - ' . $entrada->getTitulo());
        }
        $output->writeln('---------------------');

        $entradas = $this->entradaRepository->findBy([], ['titulo' => 'ASC']);
        foreach ($entradas as $entrada) {
            $output->writeln($entrada->getSlug() . ' - ' . $entrada->getTitulo());
        }
        $output->writeln('---------------------');

        $entrada = $this->entradaRepository->findOneBy(['slug' => 'Entrada-tres']);
        $output->writeln($entrada->getTitulo());
        $output->writeln('---------------------');

        $espacio = $this->espacioRepository->findOneBy(['nombre' => 'ESPACIO 2']);
        $categorias = $this->categoriaRepository->findBy(['espacio' => $espacio]);
        foreach ($categorias as $categoria) {
            $output->writeln($categoria->getNombre());
        }
        $output->writeln('---------------------');

        $categorias2 = $espacio->getCategorias();
        foreach ($categorias2 as $categoria) {
            $output->writeln($categoria->getNombre());
        }
        $output->writeln('---------------------');

        $dql = 'SELECT ent FROM App\Entity\Entrada ent ORDER BY ent.titulo ASC';
        $query = $this->em->createQuery($dql);
        $entradas = $query->execute();
        foreach ($entradas as $entrada) {
            $output->writeln($entrada->getSlug() . ' - ' . $entrada->getTitulo());
        }
        $output->writeln('---------------------');

        $dql = 'SELECT e FROM App\Entity\Entrada e WHERE e.slug = :pslug';
        $query = $this->em->createQuery($dql);
        $query->setParameter('pslug', 'Entrada-tres');
        $entradas = $query->execute();
        foreach ($entradas as $entrada) {
            $output->writeln($entrada->getSlug() . ' - ' . $entrada->getTitulo());
        }
        $output->writeln('---------------------');

        return Command::SUCCESS;
    }
}
