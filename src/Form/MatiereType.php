<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Matiere;
use App\Entity\Mention;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomMatiere')
            ->add('codeMatiere')
           /* ->add('professeur',EntityType::class,[
                'class' => User::class,
                'query_builder' => function(EntityRepository  $user){
                    return $user->createQueryBuilder('u')
                        ->andWhere('u.roles LIKE :roles')
                        ->setParameter('roles', '%"ROLE_PROFESSEUR"%')
                        ->orderBy('u.nom', 'ASC');
                },
                'choice_label' => 'nom'
            ])*/
            ->add('classe',EntityType::class,[
                'class' => Classes::class,
                'choice_label' => function($classe){
                    return $classe->getClasseMention();
                },
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Matiere::class,
        ]);
    }
}
