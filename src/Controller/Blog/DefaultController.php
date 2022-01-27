<?php

namespace App\Controller\Blog;

use App\Repository\CategoriaRepository;
use App\Repository\EspacioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/blog")
     */
    public function index(CategoriaRepository $categoriaRepository, EspacioRepository $espacioRepository): Response
    {
        //$espacio = $espacioRepository->find(1);
        //$categorias = $categoriaRepository->findByEspacio($espacio);
        return $this->render('blog/index.html.twig');
    }

    /**
     * @Route("/blog/{slug}")
     */
    public function entrada(): Response
    {
        return $this->render('blog/entrada.html.twig');
    }

    /**
     * @Route("/admin")
     */
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
