<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtiquetaController extends AbstractController
{
    /**
     * @Route("/etiqueta", name="etiqueta")
     */
    public function index(): Response
    {
        return $this->render('etiqueta/index.html.twig', [
            'controller_name' => 'EtiquetaController',
        ]);
    }
}
