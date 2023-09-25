<?php

namespace App\Controller\Admin;

use App\Entity\Skin;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class SkinCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Skin::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('name'),
            TextField::new('rarety'),
            AssociationField::new('wardrobe')
        ];
    }
    
}
