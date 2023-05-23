<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'=>'name of your wish : '
            ])
            ->add('description', TextareaType::class, [
                //désactive la verif html uniquement pour ce champ
                'required'=>false,
                'label'=>'Describe your wish : '
            ])
            ->add('author', TextType::class)
            ->add('category', EntityType::class, [
                'class'=>Category::class,
                'choice_label'=>'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
            //desactive la vérif html pour tous les champs
            //'required'=>false
        ]);
    }
}
