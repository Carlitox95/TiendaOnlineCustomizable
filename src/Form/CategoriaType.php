<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,array('label'=>'Nombre de la Categoria','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))
            ->add('descripcion',TextType::class,array('label'=>'Descripcion de los Productos','attr'  => ['class' => 'input-field col s12','tipoInput' => 'input']))
            ->add('save', SubmitType::class,array('label'=>'Guardar','attr' => ['class' => 'waves-effect waves-light btn colorOficial white-text','tipoInput' => 'button'])); 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
