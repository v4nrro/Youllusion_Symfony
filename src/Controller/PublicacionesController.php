<?php

namespace App\Controller;

use App\Entity\Publicaciones;
use App\Form\PublicacionesType;
use App\Repository\PublicacionesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/publicaciones')]
final class PublicacionesController extends AbstractController
{
    #[Route(name: 'app_publicaciones_index', methods: ['GET'])]
    public function index(PublicacionesRepository $publicacionesRepository): Response
    {
        return $this->render('publicaciones/index.html.twig', [
            'publicaciones' => $publicacionesRepository->findAll(),
        ]);
    }

    #[Route('/busqueda', name: 'app_publicaciones_index_busqueda', methods: ['POST'])]
    public function busqueda(Request $request, PublicacionesRepository $publicacionesRepository): Response
    {
        $busqueda = $request->request->get('busqueda');
        $publicacione = $publicacionesRepository->findLikeTitulo($busqueda);
        return $this->render('publicaciones/index.html.twig', [
            'publicaciones' => $publicacione
        ]);
    }

    #[Route('/mis-publicaciones', name: 'app_publicaciones_mis_publicaciones', methods: ['GET'])]
    public function misPublicaciones(PublicacionesRepository $publicacionesRepository): Response
    {
        $usuario = $this->getUser();
        $publicacione = $publicacionesRepository->findLikeUsuario($usuario->getId());
        return $this->render('publicaciones/mis-publicaciones.html.twig', [
            'publicaciones' => $publicacione
        ]);
    }

    #[Route('/new', name: 'app_publicaciones_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publicacione = new Publicaciones();
        $form = $this->createForm(PublicacionesType::class, $publicacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $file almacena el archivo subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['imagen']->getData();

            // Generamos un nombre único
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('images_directory_publicaciones'), $fileName);

            // Actualizamos el nombre del archivo en el objeto imagen al nuevo generado
            $publicacione->setImagen($fileName);

            //Actualizamos el id del usuario que añade la imagen
            $usuario = $this->getUser();
            $publicacione->setUsuario($usuario);

            $entityManager->persist($publicacione);
            $entityManager->flush();

            return $this->redirectToRoute('app_publicaciones_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publicaciones/new.html.twig', [
            'publicacione' => $publicacione,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publicaciones_show', methods: ['GET'])]
    public function show(Publicaciones $publicacione): Response
    {
        return $this->render('publicaciones/show.html.twig', [
            'publicacione' => $publicacione,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_publicaciones_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publicaciones $publicacione, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicacionesType::class, $publicacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $file almacena el archivo subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form['imagen']->getData();

            // Generamos un nombre único
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('images_directory_publicaciones'), $fileName);

            // Actualizamos el nombre del archivo en el objeto imagen al nuevo generado
            $publicacione->setImagen($fileName);

            $entityManager->persist($publicacione);
            $entityManager->flush();

            return $this->redirectToRoute('app_publicaciones_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publicaciones/edit.html.twig', [
            'publicacione' => $publicacione,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publicaciones_delete', methods: ['POST'])]
    public function delete(Request $request, Publicaciones $publicacione, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $publicacione->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($publicacione);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publicaciones_index', [], Response::HTTP_SEE_OTHER);
    }
}
