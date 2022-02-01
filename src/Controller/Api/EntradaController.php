<?php

namespace App\Controller\Api;

use App\Entity\Entrada;
use App\Repository\CategoriaRepository;
use App\Repository\EntradaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @Route("/api/entrada")
 */
class EntradaController extends AbstractController
{
    private $entradaRepository;
    private $em;

    public function __construct(EntradaRepository $entradaRepository, EntityManagerInterface $em)
    {
        $this->entradaRepository = $entradaRepository;
        $this->em = $em;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function index(): Response
    {
        $entradas = $this->entradaRepository->findBy([], ['titulo' => 'ASC']);
        $resultado = [];
        foreach ($entradas as $entrada) {
            $resultado[] = [
                'id' => $entrada->getId(),
                'slug' => $entrada->getSlug(),
                'titulo' => $entrada->getTitulo()
            ];
        }
        return new JsonResponse($resultado);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function add(Request $request, CategoriaRepository $categoriaRepository): Response
    {
        $content = json_decode($request->getContent(), true);

        $entrada = new Entrada();
        $categoria = $categoriaRepository->findOneBy(['nombre' => $content['categoria']]);
        $entrada->setCategoria($categoria);
        $entrada->setTitulo($content['titulo']);
        $entrada->setResumen($content['resumen']);
        $entrada->setTexto($content['texto']);
        $entrada->setFecha(\DateTime::createFromFormat('Y-m-d', $content['fecha']));
        $entrada->setEstado(1);

        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($content['titulo']);
        $entrada->setSlug($slug);

        $this->em->persist($entrada);
        $this->em->flush();

        return new JsonResponse(['respuesta' => 'ok']);
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function detail($id): Response
    {
        $entrada = $this->entradaRepository->find($id);
        return new JsonResponse([
            'id' => $entrada->getId(),
            'titulo' => $entrada->getTitulo(),
            'resumen' => $entrada->getResumen(),
            'texto' => $entrada->getTexto(),
            'fecha' => $entrada->getFecha()->format('Y-m-d'),
            'slug' => $entrada->getSlug(),
            'categoria' => $entrada->getCategoria()->getNombre()
        ]);
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function update(Request $request, $id, CategoriaRepository $categoriaRepository): Response
    {
        $content = json_decode($request->getContent(), true);
        $entrada = $this->entradaRepository->find($id);
        if (isset($content['texto'])) {
            $entrada->setTexto($content['texto']);
        }
        if (isset($content['resumen'])) {
            $entrada->setResumen($content['resumen']);
        }
        if (isset($content['titulo'])) {
            $entrada->setTitulo($content['titulo']);
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($content['titulo']);
            $entrada->setSlug($slug);
        }
        if (isset($content['fecha'])) {
            $fecha = \DateTime::createFromFormat('Y-m-d', $content['fecha']);
            $fecha->setTime(0, 0, 0);
            $entrada->setFecha($fecha);
        }
        if (isset($content['categoria'])) {
            $categoria = $categoriaRepository->findOneBy(['nombre' => $content['categoria']]);
            $entrada->setCategoria($categoria);
        }
        $this->em->flush();

        return new JsonResponse(['respuesta' => 'ok']);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        $entrada = $this->entradaRepository->find($id);
        $this->em->remove($entrada);
        $this->em->flush();
        return new JsonResponse(['respuesta' => 'ok']);
    }
}
