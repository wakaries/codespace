<?php

namespace App\Controller\Api;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/usuario")
 */
class UsuarioController extends AbstractController {

    private $em;
    private $usuarioRepository;

    public function __construct(EntityManagerInterface $em, UsuarioRepository $usuarioRepository)
    {
        $this->em = $em;
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function list(Request $request)
    {
        $perfil = $request->query->get('perfil');
        if ($perfil == null) {
            $usuarios = $this->usuarioRepository->findBy([], ['nombre' => 'ASC']);
        } else {
            $usuarios = $this->usuarioRepository->findBy(['perfil' => $perfil], ['nombre' => 'ASC']);
        }
        $resultado = [];
        foreach ($usuarios as $usuario) {
            $resultado[] = [
                'id' => $usuario->getId(),
                'email' => $usuario->getEmail(),
                'nombre' => $usuario->getNombre()
            ];
        }
        return new JsonResponse($resultado);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function add(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $usuario = new Usuario();
        $usuario->setEmail($content['email']);
        $usuario->setNombre($content['nombre']);
        $usuario->setPassword($content['password']);
        $usuario->setPerfil($content['perfil']);
        $usuario->setRoles($content['roles']);

        $this->em->persist($usuario);
        $this->em->flush();

        return new JsonResponse([
            'result' => 'ok'
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function detail($id)
    {
        $usuario = $this->usuarioRepository->find($id);

        return new JsonResponse([
            'id' => $usuario->getId(),
            'email' => $usuario->getEmail(),
            'nombre' => $usuario->getNombre(),
            'perfil' => $usuario->getPerfil(),
            'roles' => $usuario->getRoles()
        ]);
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function update(Request $request, $id)
    {
        $content = json_decode($request->getContent(), true);
        $usuario = $this->usuarioRepository->find($id);

        if (isset($content['email'])) {
            $usuario->setEmail($content['email']);
        }
        if (isset($content['nombre'])) {
            $usuario->setNombre($content['nombre']);
        }
        if (isset($content['password'])) {
            $usuario->setPassword($content['password']);
        }
        if (isset($content['perfil'])) {
            $usuario->setPerfil($content['perfil']);
        }
        if (isset($content['roles'])) {
            $usuario->setRoles($content['roles']);
        }
        $this->em->flush();

        return new JsonResponse([
            'result' => 'ok'
        ]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function delete($id)
    {
        $usuario = $this->usuarioRepository->find($id);
        $this->em->remove($usuario);
        $this->em->flush();

        return new JsonResponse([
            'result' => 'ok'
        ]);
    }

}
