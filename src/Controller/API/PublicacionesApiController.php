<?php

namespace App\Controller\API;

use App\BLL\PublicacionesBLL;
use App\Entity\Publicaciones;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api')]
class PublicacionesApiController extends BaseApiController
{
    #[Route('/prueba', name: 'api_prueba', methods: ["GET"])]
    public function pruebaApi(): JsonResponse
    {
        return $this->json([
            'message' => 'Bienvenido al nuevo controlador!',
        ]);
    }

    #[Route('/publicacionesapinueva', name: 'api_post_publicaciones', methods: ["POST"])]
    public function post(Request $request, PublicacionesBLL $publicacionesBLL)
    {
        $data = $this->getContent($request);
        $publicaciones = $publicacionesBLL->nueva($data);
        return $this->getResponse($publicaciones, Response::HTTP_CREATED);
    }

    #[Route('/publicaionesapi/{id}', name: 'api_get_publicacion', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getOne(Publicaciones $publicacion, PublicacionesBLL $publicacionBLL)
    {
        return $this->getResponse($publicacionBLL->toArray($publicacion));
    }

    #[Route('/publicacionesapi', name: 'api_get_publicaciones', methods: ['GET'])]
    #[Route('/publicacionesapi/ordenadas/{order}', name: 'api_get_publicaciones_ordenadas', methods: ['GET'])]
    public function getAll(Request $request, PublicacionesBLL $publicacionBLL, $order = 'id')
    {
        $titulo = $request->query->get('titulo');
        $publicaciones = $publicacionBLL->getPublicaciones($order, $titulo);
        return $this->getResponse($publicaciones);
    }

    #[Route('/publicacionesapi/{id}', name: 'api_delete_publicacion', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(Publicaciones $publicacion, PublicacionesBLL $publicacionBLL)
    {
        $publicacionBLL->delete($publicacion);
        return $this->getResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/publicacionesapi/{id}', name: 'api_update_publicacion', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function update(Request $request, Publicaciones $publicacion, PublicacionesBLL $publicacionBLL)
    {
        $data = $this->getContent($request);
        $publicacion = $publicacionBLL->actualizaPublicacion($publicacion, $data);
        return $this->getResponse($publicacion, Response::HTTP_OK);
    }
}
