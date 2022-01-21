<?php

namespace App\Form;

use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Categoria;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductoCategoriasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            //->add('categorias')
            ->add('categorias', EntityType::class, [
             'class' => Categoria::class,
             'choice_label' => 'nombre',
             'multiple' => true,
             'expanded' => false,
            ])
            ->add('save', SubmitType::class,array('label'=>'Guardar','attr' => ['class' => 'waves-effect waves-light btn colorOficial white-text','tipoInput' => 'button']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
