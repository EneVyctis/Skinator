<?php

namespace App\Controller\Admin;

use App\Entity\Showcase;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ShowcaseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Showcase::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('creator'),
            BooleanField::new('published')
                ->onlyOnForms()
                ->hideWhenCreating(),
            TextField::new('description'),

            AssociationField::new('skin')
                ->onlyOnForms()
                // on ne souhaite pas gérer l'association entre les
                // [objets] et la [galerie] dès la crétion de la
                // [galerie]
                ->hideWhenCreating()
                ->setTemplatePath('admin/fields/showcase_skin.html.twig')
                // Ajout possible seulement pour des [objets] qui
                // appartiennent même propriétaire de l'[inventaire]
                // que le [createur] de la [galerie]
                ->setQueryBuilder(
                    function (QueryBuilder $queryBuilder) {
                        // récupération de l'instance courante de [galerie]
                        $currentShowcase = $this->getContext()->getEntity()->getInstance();
                        $creator = $currentShowcase->getCreator();
                        $memberId = $creator->getId();
                        // charge les seuls [objets] dont le 'owner' de l'[inventaire] est le [createur] de la galerie
                        $queryBuilder->leftJoin('entity.wardrobe', 'i')
                            ->leftJoin('i.owner', 'm')
                            ->andWhere('m.id = :member_id')
                            ->setParameter('member_id', $memberId);    
                        return $queryBuilder;
                    }
                   ),
        ];
    }
}
