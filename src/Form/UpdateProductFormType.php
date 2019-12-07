<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['name']],
                'label' => false,
                'required' => true,
            ])
            ->add('description',TextareaType::class,[
                'attr' =>['class'=> 'form-control w-100',"placeholder"=>$options['description'], "cols"=>"30", "rows"=>"10"],
                'label' => false,
                'required' => true,])
            ->add('price',IntegerType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['price']],
                'label' => false,
                'required' => true,])
            ->add('category',ChoiceType::class,[
                'choices' => [
                    'IMMOBILIER' => 'IMMOBILIER',
                    'MEUBLE' => 'MEUBLE' ,
                    'VEHICULE' => 'VEHICULE' ,
                    'LOISIR' => 'LOISIR' ,
                    'MULTIMEDIA' => 'MULTIMEDIA' ,
                    'MATERIEL' => 'MATERIEL' ,
                ],
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['category']],
                'label' => false,
                'required' => true,])
            ->add('state',ChoiceType::class,[
                'choices' => [
                    'neuf' => 'neuf',
                    'bon état' => 'bon état' ,
                    'mauvais état' => 'mauvais état',
                    "Mais c'etait sur" => "Mais c'etait sur",
                    'label' => false,
                ],
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['state']],
                'label' => false,
                'required' => true,])
            ->add('submit',SubmitType::class,[
                'attr'=> ['class'=> 'btn amado-btn w-100'],
                'label'=> "Publier"
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'name' => 'string',
            'description' => 'string',
            'price' => 'integer',
            'category' => 'string',
            'state' => 'string',
        ]);
        $resolver->setAllowedTypes('name', 'string');
        $resolver->setAllowedTypes('description', 'string');
        $resolver->setAllowedTypes('price', 'integer');
        $resolver->setAllowedTypes('category', 'string');
        $resolver->setAllowedTypes('state', 'string');
    }
}
