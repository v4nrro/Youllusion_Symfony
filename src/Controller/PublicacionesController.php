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

    #[Route('/new', name: 'app_publicaciones_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publicacione = new Publicaciones();
        $form = $this->createForm(PublicacionesType::class, $publicacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    #[Route('/{id}/edit', name: 'app_publicaciones_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publicaciones $publicacione, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicacionesType::class, $publicacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        if ($this->isCsrfTokenValid('delete'.$publicacione->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($publicacione);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publicaciones_index', [], Response::HTTP_SEE_OTHER);
    }
}
