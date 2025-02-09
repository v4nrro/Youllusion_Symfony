<?php

namespace App\BLL;

use App\Entity\Publicaciones;
use App\Entity\Usuarios;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class PublicacionesBLL extends BaseBLL
{
    public function nueva(array $data)
    {
        $publicacion = new Publicaciones();
        return $this->actualizaPublicacion($publicacion, $data);
    }

    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function setSecurity(Security $security)
    {
        $this->security = $security;
    }

    public function getPublicaciones(?string $order, ?string $titulo,)
    {
        $publicaciones = $this->em->getRepository(Publicaciones::class)->findPublicaciones(
            $order,
            $titulo,
            $usuario = null
        );
        return $this->entitiesToArray($publicaciones);
    }



    public function actualizaPublicacion(Publicaciones $publicacion, array $data)
    {
        $publicacion->setTitulo($data['titulo']);
        $publicacion->setImagen($data['imagen']);
        $publicacion->setDescripcion($data['descripcion']);

        $usuario = $this->em->getRepository(Usuarios::class)->find($data['usuario']);
        $publicacion->setUsuario($usuario);

        return $this->guardaValidando($publicacion);
    }

    public function toArray(Publicaciones $imagen)
    {
        if (is_null($imagen))
            return null;
        return [
            'id' => $imagen->getId(),
            'titulo' => $imagen->getTitulo(),
            'imagen' => $imagen->getImagen(),
            'descripcion' => $imagen->getDescripcion(),
            'usuario' => $imagen->getUsuario()->getId()
        ];
    }
}
