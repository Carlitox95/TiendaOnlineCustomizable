<?php

namespace App\Form;

use App\Entity\Configuracion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ConfiguracionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('tipo',TextType::class,array('label'=>'Tipo de Mensaje a Mostrar (donde se usa)','attr'  => ['class' => 'input-field col s12','readonly' => 'true','tipoInput' => 'input']))
            

            ->add('mensaje',TextareaType::class,array('label'=>'Mensaje Completo','required' => false,'attr' => ['class' => 'materialize-textarea','tipoInput' => 'input'])) 
            ->add('activo',CheckboxType::class, array(
                'label'=>'Activo',
                'required' => false,
                'attr' => array('class'=>'browser-default','tipoInput' => 'checkbox'),
            ))
            ->add('save', SubmitType::class,array('label'=>'Guardar','attr' => ['class' => 'waves-effect waves-light btn colorOficial white-text','tipoInput' => 'button']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Configuracion::class,
        ]);
    }
}
