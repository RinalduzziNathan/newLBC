<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('name', TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>"Veuillez donner un titre précis de l'annonce."],
                'label' => false,
                'required' => true,
            ])
            ->add('description',TextareaType::class,[
                'attr' =>['class'=> 'form-control w-100',"placeholder"=>"Veuillez donner une description précise et complète de l'annonce et des condition de vente.", "cols"=>"30", "rows"=>"10"],
                'label' => false,
                'required' => true,])
            ->add('price',IntegerType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>"Choisissez un prix réaliste."],
                'label' => false,
                'required' => true,])
            ->add('category',TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>"Veuillez donner un titre précis de l'annonce."],
                'label' => false,
                'required' => true,
            ])
            ->add('state',TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>"Veuillez donner un titre précis de l'annonce."],
                'label' => false,
                'required' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
