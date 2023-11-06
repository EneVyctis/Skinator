<?php

namespace App\Controller;

use App\Entity\Showcase;
use App\Entity\Skin;
use App\Form\Showcase2Type;
use App\Repository\ShowcaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/showcase')]
class ShowcaseController extends AbstractController
{
    #[Route('/', name: 'app_showcase_index', methods: ['GET'])]
    public function index(ShowcaseRepository $showcaseRepository): Response
    {
        return $this->render('showcase/index.html.twig', [
            'showcases' => $showcaseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_showcase_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $showcase = new Showcase();
        $form = $this->createForm(Showcase2Type::class, $showcase);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($showcase);
            $entityManager->flush();

            return $this->redirectToRoute('app_showcase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('showcase/new.html.twig', [
            'showcase' => $showcase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_showcase_show', methods: ['GET'])]
    public function show(Showcase $showcase): Response
    {
        return $this->render('showcase/show.html.twig', [
            'showcase' => $showcase,
        ]);
    }   

    #[Route('/{id}/edit', name: 'app_showcase_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Showcase $showcase, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Showcase2Type::class, $showcase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_showcase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('showcase/edit.html.twig', [
            'showcase' => $showcase,
            'form' => $form,
        ]);
    }

    #[Route('/{showcase_id}/skin/{skin_id}', methods: ['GET'], name: 'app_showcase_skin_show')]
   public function skinShow(
       #[MapEntity(id: 'showcase_id')]
       Showcase $showcase,
       #[MapEntity(id: 'skin_id'    )]
       Skin $skin
   ): Response

   {
    if(! $showcase->getSkins()->contains($skin)) {
        throw $this->createNotFoundException("Couldn't find such a skin in this showcase!");
}

if(! $showcase->isIsPublic()) {
        throw $this->createAccessDeniedException("You cannot access the requested ressource!");
}

return $this->render('showcase/skin_show.html.twig', [
        'skin' => $skin,
        'showcase' => $showcase
  ]);
   }

    #[Route('/{id}', name: 'app_showcase_delete', methods: ['POST'])]
    public function delete(Request $request, Showcase $showcase, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$showcase->getId(), $request->request->get('_token'))) {
            $entityManager->remove($showcase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_showcase_index', [], Response::HTTP_SEE_OTHER);
    }
}
