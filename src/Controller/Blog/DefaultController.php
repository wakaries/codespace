<?php

namespace App\Controller\Blog;

use App\Repository\CategoriaRepository;
use App\Repository\EntradaRepository;
use App\Repository\EspacioRepository;
use App\Repository\UsuarioRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
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
    public function entrada($slug, EntradaRepository $entradaRepository): Response
    {
        //$entrada = $entradaRepository->getBySlugDql($slug);
        $entrada = $entradaRepository->getBySlugQueryBuilder($slug);
        return $this->render('blog/entrada.html.twig', [
            'entrada' => $entrada
        ]);
    }

    /**
     * @Route("/admin")
     */
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/token")
     */
    public function token(UsuarioRepository $usuarioRepository, JWTTokenManagerInterface $tokenManager): Response
    {
        $user = $usuarioRepository->find(1);
        $token = $tokenManager->create($user);
        return new Response($token);
    }
}
