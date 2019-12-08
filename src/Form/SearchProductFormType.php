<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recherche',TextType::class,[
                'attr' =>['class'=> 'form-control w-100',"placeholder"=>"Entrer une recherche!", "cols"=>"30", "rows"=>"10"],
                'label' => false,
                'required' => true,])
        ->add('submit',SubmitType::class,[
            'attr'=> ['class'=> 'btn amado-btn w-100 active','type'=>'button'],
            'label'=> "Rechercher"
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
