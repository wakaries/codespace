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
    public function index(EntradaRepository $entradaRepository, CategoriaRepository $categoriaRepository, EspacioRepository $espacioRepository): Response
    {
        $entradas = $entradaRepository->findEntradasMasRecientes(4);
        return $this->render('blog/index.html.twig', [
            'entradas' => $entradas
        ]);
    }

    /**
     * @Route("/test1/{idEspacio}")
     */
    public function test1($idEspacio, EntradaRepository $entradaRepository, EspacioRepository $espacioRepository): Response
    {
        // LISTADO DE ENTRADAS PARA UN ESPACIO
        $espacio = $espacioRepository->find($idEspacio);
        $entradas = $entradaRepository->findByEspacio($espacio);
        return $this->render('blog/index.html.twig', [
            'entradas' => $entradas
        ]);
    }

    /**
     * @Route("/test2")
     */
    public function test2(EntradaRepository $entradaRepository, CategoriaRepository $categoriaRepository): Response
    {
        $categoria1 = $categoriaRepository->find(1);
        $categoria2 = $categoriaRepository->find(2);
        $categorias = [$categoria1, $categoria2];
        // LISTADO DE ENTRADAS PARA VARIAS CATEGORIAS
        $entradas = $entradaRepository->findByCategorias($categorias);
        return $this->render('blog/index.html.twig', [
            'entradas' => $entradas
        ]);
    }

    /**
     * @Route("/test3/{idEspacio}/{idUsuario}")
     */
    public function test3($idEspacio, $idUsuario, EntradaRepository $entradaRepository, EspacioRepository $espacioRepository, UsuarioRepository $usuarioRepository): Response
    {

        // LISTADO DE ENTRADAS DE UN USUARIO EN UN ESPACIO
        $entradas = $entradaRepository->findByUsuarioEspacio($usuario, $espacio);
        return $this->render('blog/index.html.twig', [
            'entradas' => $entradas
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="blog_entrada")
     */
    public function entrada($slug, EntradaRepository $entradaRepository): Response
    {
        $entrada = $entradaRepository->findOneBy(['slug' => $slug]);
        if ($entrada == null) {
            throw $this->createNotFoundException('Entrada no encontrada');
        }
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
