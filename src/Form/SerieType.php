<?php

namespace App\Form;

use App\Entity\Serie;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('CreatedAt')
            ->add('StopedAt')
            ->add('image')
            ->add('SeasonNumber')
            ->add('categorie',EntityType::class,['attr'=>['class'=>'form-control'],'class'=> Categorie::class,'choice_label' => 'name'])
            ->add('submit',SubmitType::class,['attr'=>['class'=>'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
