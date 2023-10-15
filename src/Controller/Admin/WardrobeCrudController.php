<?php

namespace App\Controller\Admin;

use App\Entity\Wardrobe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class WardrobeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Wardrobe::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('name'),
            TextField::new('description'),
            AssociationField::new("owner"),
            AssociationField::new('skin')
                        ->onlyOnDetail()
                        ->setTemplatePath('admin/fields/wardrobe_skin.html.twig')
        ];
    }
    
    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
}
