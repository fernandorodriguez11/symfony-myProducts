<?php

namespace App\Form;

use App\Entity\Productos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('foto_producto',FileType::class, [
                'label' => 'Seleccione una imagen',
                'mapped' => false,
                'required' => true])
            ->add('nombre', TextType::class)
            ->add('tienda', TextType::class)
            ->add('ubicacion_casa', ChoiceType::class, ['choices' => ['cocina' => 'cocina','baño' => 'baño','casa' => 'casa']])
            ->add('tipo_producto', ChoiceType::class, ['choices' => ['alimentacion' => 'alimentacion','limpieza' => 'limpieza']])
            ->add('insertar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Productos::class,
        ]);
    }
}
