<?php

namespace App\Controller;

use App\Entity\Weapon;
use App\Entity\Wardrobe;
use App\Form\WeaponType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class WeaponController extends AbstractController
{
    #[Route('weapon/{id}', name: 'weapon_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Weapon $weapon): Response
    {
        return $this->render('weapon/show.html.twig', [ 'weapon' => $weapon]);
    }   

    #[Route('weapon/new/{wardrobe_id}', name: 'app_weapon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, #[MapEntity(id : 'wardrobe_id')] Wardrobe $wardrobe): Response
    {
        $hasAccess = ($this->getUser()->getMember() == $wardrobe->getOwner());
        if(! $hasAccess){
            throw $this->createAccessDeniedException("Don't mind other's people business");
        }
        else{
        $weapon = new Weapon();
        $weapon->setWardrobe($wardrobe);
        $form = $this->createForm(WeaponType::class, $weapon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($weapon);
            $entityManager->flush();    
            $this->addFlash('message', 'Bien ajouté');

            return $this->redirectToRoute('app_member_index');
        }

        return $this->render('weapon/new.html.twig', [
            'weapon'=> $weapon,
            'form'=> $form,
        ]);
    }
    }
}
