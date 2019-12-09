<?php

namespace App\Form;

use App\Entity\ProductImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImportImageProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('filename',FileType::class, [
                'label' => false,
                'required' => true,
            'constraints' => [
                new File([
                    'maxSize' => '10024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/gif',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image (jpeg/gif/png)',
                ])
            ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductImage::class,
        ]);
    }
}
