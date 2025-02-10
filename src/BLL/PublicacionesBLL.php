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

    public function getPublicaciones(?string $titulo)
    {
        $publicaciones = $this->em->getRepository(Publicaciones::class)->findLikeTitulo(
            $titulo
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

    public function toArray(Publicaciones $publicacion)
    {
        if (is_null($publicacion))
            return null;
        return [
            'id' => $publicacion->getId(),
            'titulo' => $publicacion->getTitulo(),
            'imagen' => $publicacion->getImagen(),
            'descripcion' => $publicacion->getDescripcion(),
            'usuario' => $publicacion->getUsuario()->getId()
        ];
    }
}
