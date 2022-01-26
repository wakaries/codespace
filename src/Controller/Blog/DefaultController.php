<?php

namespace App\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {

    /**
     * @Route("/blog")
     */
    public function index(): Response
    {
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
