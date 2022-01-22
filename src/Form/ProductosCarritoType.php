<?php

namespace App\Form;

use App\Entity\ProductosCarrito;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProductosCarritoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cantidad',TextType::class,array('label'=>'Cantidad','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))
            ->add('save', SubmitType::class,array('label'=>'Confirmar','attr' => ['class' => 'waves-effect waves-light btn colorOficial white-text','tipoInput' => 'button']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductosCarrito::class,
        ]);
    }
}
