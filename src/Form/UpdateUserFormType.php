<?php

namespace App\Form;

use App\Entity\UserLogin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username' , TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['username']],
                'label' => false,
            ])
            ->add('firstname', TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['firstname']],
                'label' => false,
                'required' => true,])
            ->add('lastname', TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['lastname']],
                'label' => false,
                'required' => true,])
            ->add('email', TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['email']],
                'label' => false,
                'required' => true,])
            ->add('phone', TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['phone']],
                'label' => false,
                'required' => true,])
            ->add('password', RepeatedType::class, [
                'options' => ['attr' => ['class' => 'password-field']],
                'label' => false,
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => [
                    'attr'=> ['class'=> 'form-control',"placeholder"=>"Mot de passe"],"label"=>false],
                'second_options' => [
                    'attr'=> ['class'=> 'form-control',"placeholder"=>"Répéter le mot de passe"],"label"=>false,],
            ])
            ->add('address', TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['address']],
                'label' => false,
                'required' => true,])
            ->add('city', TextType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['city']],
                'label' => false,
                'required' => true,])
            ->add('postalcode', IntegerType::class,[
                'attr'=> ['class'=> 'form-control',"placeholder"=>$options['postalcode']],
                'label' => false,
                'required' => true,] )
            ->add('description',TextareaType::class,[
                'attr' =>['class'=> 'form-control w-100',"placeholder"=>$options['description'], "cols"=>"30", "rows"=>"10"],
                'label' => false,
                'required' => false,])
            ->add('Editer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserLogin::class,
            'username' => 'string',
            'firstname' => 'string',
            'lastname' => 'string',
            'email' => 'string',
            'phone' => 'string',
            'password' => 'string',
            'address' => 'string',
            'city' => 'string',
            'postalcode' => 'integer',
            'description' => 'string',
        ]);
        $resolver->setAllowedTypes('username', 'string');
        $resolver->setAllowedTypes('firstname', 'string');
        $resolver->setAllowedTypes('lastname', 'string');
        $resolver->setAllowedTypes('email', 'string');
        $resolver->setAllowedTypes('phone', 'string');
        $resolver->setAllowedTypes('password', 'string');
        $resolver->setAllowedTypes('address', 'string');
        $resolver->setAllowedTypes('city', 'string');
        $resolver->setAllowedTypes('postalcode', 'integer');
        $resolver->setAllowedTypes('description', 'string');
    }
}
