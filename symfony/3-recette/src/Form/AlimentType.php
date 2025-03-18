<?php

namespace App\Form;

use App\Entity\Aliment;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class AlimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('imageFile', FileType::class, [ 
                'required' => false,
              
            ])
            ->add('calorie')
            ->add('proteine')
            ->add('glucide')
            ->add('lipide')
            ->add('categorie',EntityType::class,[
                'class'=>Categorie::class,
                'choice_label'=>'libelle'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aliment::class,
        ]);
    }
}
