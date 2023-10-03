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

    /* List all Wardrobes */

    #[Route('/wardrobe/list', name: 'wardrobe_list', methods: ['GET'])]
    public function listAction(WardrobeRepository $wardrobeRepository)  
    {
            $htmlpage = '<!DOCTYPE html>
    <html>
            <head>
                <meta charset="UTF-8">
                <title>wardrobe list!</title>
            </head>
            <body>
                <h1>wardrobe list</h1>  
                <p>Here all wardrobes</p>
            </body>
    </html>';

        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
    }

    /**
     * List all wardrobe entities.
     */

    #[Route('/list', name: 'wardrobe_list', methods: ['GET'])]
    #[Route('/index', name: 'wardrobe_index', methods: ['GET'])]
    public function listWardrobes(ManagerRegistry $doctrine)
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wardrobe list!</title>
    </head>
    <body>
        <h1>wardrobe list</h1>
        <p>Here are all your wardrobe:</p>
        <ul>';
        
        $entityManager= $doctrine->getManager();
        $wardrobes = $entityManager->getRepository(Wardrobe::class)->findAll();
        foreach($wardrobes as $wardrobe) {
            $url = $this->generateUrl(
                'wardrobe_show',
                ['id' => $wardrobe->getId()]);
            $htmlpage .= '<li>
            <a href="'. $url .'">'. $wardrobe->getName() .'</a></li>';
         }
        $htmlpage .= '</ul>';

        $htmlpage .= '</body></html>';
        
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
    }
     /**
     * Finds and displays a todo entity.
     */
    #[Route('/{id}', name: 'wardrobe_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showAction(Wardrobe $wardrobe): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>wardrobe n° '.$wardrobe->getId().' details</title>
    </head>
    <body>
        <h2>Wardrobe Details :</h2>
        <ul>
        <dl>';
        
        $htmlpage .= '<dt>Wardrobe</dt><dd>' . $wardrobe->getName() . '</dd>';
        $htmlpage .= '<dt>Description</dt> <dd> ' . $wardrobe->getDescription() . '</dd>';
        $htmlpage .= '<dt>Wardrobe of</dt> <dd> '. $wardrobe->getOwner() . '</dd>';
        $htmlpage .= '</dl>';
        $htmlpage .= '</ul></body></html>';
                
        return new Response(
                $htmlpage,
                Response::HTTP_OK,
                array('content-type' => 'text/html')
                );
    }
}
