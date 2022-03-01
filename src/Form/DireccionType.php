<?php

namespace App\Form;

use App\Entity\Direccion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class DireccionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder  
         ->add('calle',TextType::class,array('label'=>'Calle','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))
         ->add('numero',TextType::class,array('label'=>'Numero','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))
         ->add('entrecalle1',TextType::class,array('label'=>'Entre Calle 1','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))
         ->add('entrecalle2',TextType::class,array('label'=>'Entre Calle 2','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))
         ->add('codigopostal',TextType::class,array('label'=>'Codigo Postal','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))
         ->add('ciudad',TextType::class,array('label'=>'Ciudad','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))
         ->add('provincia',TextType::class,array('label'=>'Provincia','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))            
         ->add('save', SubmitType::class,array('label'=>'Guardar Cambios','attr' => ['class' => 'waves-effect waves-light btn colorOficial white-text','tipoInput' => 'button'])); 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Direccion::class,
        ]);
    }
}
