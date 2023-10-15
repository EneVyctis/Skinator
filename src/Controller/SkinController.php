<?php

namespace App\Controller;

use App\Entity\Skin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class SkinController extends AbstractController
{
    #[Route('skin/{id}', name: 'skin_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Skin $skin): Response
    {
        return $this->render('skin/show.html.twig', [ 'skin' => $skin]);
    }   
}
