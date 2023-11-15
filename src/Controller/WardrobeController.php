<?php

namespace App\Controller;

use App\Entity\Wardrobe;
use App\Entity\Member;
use App\Form\WardrobeType;
use App\Repository\WardrobeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/wardrobe')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class WardrobeController extends AbstractController
{
    #[Route('/', name: 'app_wardrobe')]
    public function index(): Response
    {
        return $this->render('wardrobe/index.html.twig', [
            'controller_name' => 'WardrobeController',
        ]);
    }

    #[Route('/new/{id}', name: 'app_wardrobe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Member $member): Response
    {
        $wardrobe = new Wardrobe();
        $wardrobe->setOwner($member);
        $form = $this->createForm(WardrobeType::class, $wardrobe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($wardrobe);
            $entityManager->flush();
            $this->addFlash('message', 'Bien ajouté');
            return $this->redirectToRoute('app_wardrobe', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wardrobe/new.html.twig', [
            'wardrobe' => $wardrobe,
            'form' => $form,
        ]);
    }

    /**
     * List all wardrobe entities.
     */

    #[Route('/list', name: 'wardrobe_list', methods: ['GET'])]
    #[Route('/index', name: 'wardrobe_index', methods: ['GET'])]
    public function listWardrobes(ManagerRegistry $doctrine)
    {
        
        $entityManager= $doctrine->getManager();
        $wardrobes = $entityManager->getRepository(Wardrobe::class)->findAll();
        return $this->render('wardrobe/wardrobeList.html.twig',
                [ 'wardrobes' => $wardrobes ]
                );
    }
     /**
     * Finds and displays a todo entity.
     */
    #[Route('/{id}', name: 'wardrobe_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function showAction(Wardrobe $wardrobe): Response
    {
        return $this->render('wardrobe/showWardrobe.html.twig', [ 'wardrobe' => $wardrobe]);
    }
}
