<?php

namespace App\Controller\Blog;

use App\Repository\EntradaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/blog")
 */
class ApiController extends AbstractController {

    private $entradaRepository;

    public function __construct(EntradaRepository $entradaRepository)
    {
        $this->entradaRepository = $entradaRepository;
    }

    /**
     * @Route("/entradas")
     */
    public function listEntradas(): JsonResponse
    {
        $entradas = $this->entradaRepository->findAll();
        $response = [];
        foreach ($entradas as $entrada) {
            $response[] = [
                'slug' => $entrada->getSlug(),
                'titulo' => $entrada->getTitulo(),
                'resumen' => $entrada->getResumen(),
                'fecha' => $entrada->getFecha()->format('Y-m-d'),
                'usuario' => $this->getUser()->getNombre()
            ];
            return new JsonResponse($response);
        }
    }

}
