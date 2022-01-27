<?php

namespace App\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/entrada")
 */
class EntradaController extends AbstractController {

    /**
     * @Route("")
     */
    public function list(): Response
    {
        return $this->render('admin/entrada/list.html.twig');
    }

    /**
     * @Route("/add")
     */
    public function add(): Response
    {
        return $this->render('admin/entrada/edit.html.twig');
    }

}
