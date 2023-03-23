<?php

namespace App\Form;
use App\Entity\Category;
use App\Entity\Wish;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('firstAirDate')
            ->add('overview')
            ->add('poster')
            ->add('tmdbId')
                                                            // instance de serie a revoir ajoute Symfony\Bridge\Doctrine\Form\Type\EntityTyp + tableux []
            ->add('wish', EntityType::class,[
                'class'=>Wish::class, // ves' klass Serie
                'choice_label'=>'name', // vibiraem name
                'query_builder' => function(EntityRepository $er){
                 return$er ->createQueryBuilder('s')
                    ->orderBy('s.name', 'ASC');
    },

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
