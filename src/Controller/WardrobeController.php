<?php

namespace App\Controller;

use App\Entity\Wardrobe;
use App\Repository\WardrobeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class WardrobeController extends AbstractController
{
    #[Route('/wardrobe', name: 'app_wardrobe')]
    public function index(): Response
    {
        return $this->render('wardrobe/index.html.twig', [
            'controller_name' => 'WardrobeController',
        ]);
    }

    /**
     * List all wardrobe entities.
     */

    #[Route('wardrobe/list', name: 'wardrobe_list', methods: ['GET'])]
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
    public function showAction(Wardrobe $wardrobe): Response
    {
        return $this->render('wardrobe/showWardrobe.html.twig', [ 'wardrobe' => $wardrobe]);
    }
}
