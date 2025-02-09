<?php

namespace App\Form;

use App\Entity\Publicaciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PublicacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imagen', FileType::class, [
                'label' => 'Nombre imagen (JPG o PNG)',
                'label_attr' => ['class' => 'etiqueta'],
                'data_class' => null,
                'constraints' => [
                new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                            ], 
                        'mimeTypesMessage' => 'Por favor, seleccione un archivo jpg o png',
                    ])
                ]])
            ->add('titulo')
            ->add('descripcion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publicaciones::class,
        ]);
    }
}
