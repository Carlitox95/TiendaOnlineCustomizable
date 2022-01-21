<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Producto;
use App\Entity\Categoria;
use App\Repository\CategoriaRepository;

class ProductoCategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorias', EntityType::class, [    
                 'class' => Categoria::class,
                 'query_builder' => function (EntityRepository $er) {
                 return $er->createQueryBuilder('u')
                 ->orderBy('u.nombre', 'ASC');
                },
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'nombre',
                'attr' => ['tipoInput' => 'multiple']
            ])
            ->add('save', SubmitType::class,array('label'=>'Guardar','attr' => ['class' => 'waves-effect waves-light btn colorOficial white-text','tipoInput' => 'button'])); 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => Producto::class,
        ]);
    }
}
