<?php

namespace App\Controller;

use App\Entity\Showcase;
use App\Entity\Weapon;
use App\Entity\Member;
use App\Form\Showcase2Type;
use App\Repository\ShowcaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/showcase')]
class ShowcaseController extends AbstractController
{
    #[Route('/', name: 'app_showcase_index', methods: ['GET'])] 
    public function index(ShowcaseRepository $showcaseRepository): Response
    {
        return $this->render('showcase/index.html.twig', [
            'showcases' => $showcaseRepository->findBy(['isPublic' => true]),
        ]);
    }

    #[Route('/new/{id}', name: 'app_showcase_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Member $creator): Response
    {
        $hasAccess = ($this->getUser()->getMember() == $creator);
        if(! $hasAccess){
            throw $this->createAccessDeniedException("Don't mind other's people business");
        }
        $showcase = new Showcase();
        $showcase->setCreator($creator);
        $form = $this->createForm(Showcase2Type::class, $showcase);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($showcase);
            $entityManager->flush();
            $this->addFlash('message', 'Bien ajouté');
            return $this->redirectToRoute('app_showcase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('showcase/new.html.twig', [
            'showcase' => $showcase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_showcase_show', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(Showcase $showcase): Response
    {
        $hasAccess = ($showcase->isisPublic()) || $this->isGranted('ROLE_ADMIN') || ($this->getUser()->getMember() == $showcase->getCreator());
        if(! $hasAccess) {
        throw $this->createAccessDeniedException("Private showcase, acces denied !");
        }
        return $this->render('showcase/show.html.twig', [
            'showcase' => $showcase,
            'user' => $this->getUser(),
        ]);
    }   

    #[Route('/{id}/edit', name: 'app_showcase_edit', methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, Showcase $showcase, EntityManagerInterface $entityManager): Response
    {   
        $hasAccess = ($this->getUser()->getMember() == $showcase->getCreator());
        if(! $hasAccess){
            throw $this->createAccessDeniedException("Don't mind other's people business");
        }
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

    #[Route('/{showcase_id}/weapon/{weapon_id}', methods: ['GET'], name: 'app_showcase_weapon_show')]
   public function weaponShow(
       #[MapEntity(id: 'showcase_id')]
       Showcase $showcase,
       #[MapEntity(id: 'weapon_id'    )]
       Weapon $weapon
   ): Response

   {
    if(! $showcase->getWeapons()->contains($weapon)) {
        throw $this->createNotFoundException("Couldn't find such a weapon in this showcase!");
}

    return $this->render('showcase/weapon_show.html.twig', [
        'weapon' => $weapon,
        'showcase' => $showcase,
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
