<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Cours;
use App\Entity\Matiere;
use App\Entity\User;
use App\Form\DataTransformer\UserTransformer;
use App\Repository\MatiereRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    private $security;
    private $userTransformer;

    public function __construct(Security $security,UserTransformer $userTransformer)
    {
        $this->security = $security;
        $this->userTransformer = $userTransformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titreCours')
            ->add('matiere',EntityType::class,[
                'class' => Matiere::class,
                'choice_label' => 'nomMatiere'

            ])
            ->add('professeur',HiddenType::class,[
                'data_class' => null,
                'data' =>  $this->security->getUser()
            ])
            ->add('classe',EntityType::class,[
                'class' => Classes::class,
                'choice_label' => function($classe){
                    return $classe->getClasseMention();
                },


            ])
            ->get('professeur')->addModelTransformer($this->userTransformer);

            /*->add('professeur')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
