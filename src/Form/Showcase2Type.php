<?php

namespace App\Form;

use App\Entity\Showcase;
use App\Repository\WeaponRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Showcase2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        $showcase = $options['data'] ?? null;
        $member = $showcase->getCreator();

        $builder
            ->add('name')
            ->add('description')
            ->add('isPublic')
            ->add('creator', null,[
                'disabled' => true,
            ])
            ->add('weapons', null, [
                'query_builder' => function ( WeaponRepository $er) use ($member) {
                    return $er->createQueryBuilder('o')
                    ->leftJoin('o.wardrobe', 'i')
                    ->andWhere('i.owner = :member')
                    ->setParameter('member', $member)
                    ;
                },
                'by_reference' => false,
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Showcase::class,
        ]);
    }
}
