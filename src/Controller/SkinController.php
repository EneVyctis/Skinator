<?php

namespace App\Controller;

use App\Entity\Skin;
use App\Entity\Wardrobe;
use App\Form\SkinType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SkinController extends AbstractController
{
    #[Route('skin/{id}', name: 'skin_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Skin $skin): Response
    {
        return $this->render('skin/show.html.twig', [ 'skin' => $skin]);
    }   

    #[Route('skin/new/{wardrobe_id}', name: 'app_skin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, #[MapEntity(id : 'wardrobe_id')] Wardrobe $wardrobe): Response
    {
        $hasAccess = ($this->getUser()->getMember() == $wardrobe->getOwner());
        if(! $hasAccess){
            throw $this->createAccessDeniedException("Don't mind other's people business");
        }
        else{
        $skin = new Skin();
        $skin->setWardrobe($wardrobe);
        $form = $this->createForm(SkinType::class, $skin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($skin);
            $entityManager->flush();    
            $this->addFlash('message', 'Bien ajouté');

            return $this->redirectToRoute('app_member_index');
        }

        return $this->render('skin/new.html.twig', [
            'skin'=> $skin,
            'form'=> $form,
        ]);
    }
    }
}
