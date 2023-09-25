<?php

namespace App\Controller\Admin;

use App\Entity\Wardrobe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class WardrobeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Wardrobe::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
