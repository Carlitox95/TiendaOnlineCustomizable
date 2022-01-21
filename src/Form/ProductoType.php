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

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo',TextType::class,array('label'=>'Codigo del Producto','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))
            ->add('nombre',TextType::class,array('label'=>'Nombre del Producto','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))
            ->add('descripcion',TextType::class,array('label'=>'Descripcion Corta','attr'  => ['class' => 'input-field col s12','tipoInput' => 'input']))
            ->add('descripcionCompleta',TextareaType::class,array('label'=>'Descripcion Completa','required' => false,'attr' => ['class' => 'materialize-textarea','tipoInput' => 'input'])) 
            ->add('stock',TextType::class,array('label'=>'Stock Disponible','required' => false,'attr' => ['class' => 'input-field col s12','tipoInput' => 'input'])) 
            ->add('activo',CheckboxType::class, array(
                'label'=>'Activo',
                'required' => false,
                'attr' => array('class'=>'browser-default','tipoInput' => 'checkbox'),
            ))
            ->add('destacado',CheckboxType::class, array(
                'label'=>'Destacar Producto (Saldra en la Pantalla Principal)',
                'required' => false,
                'attr' => array('class'=>'browser-default','tipoInput' => 'checkbox'),
            )) 
            ->add('Precio',TextType::class,array('label'=>'Precio','attr' => ['class' => 'input-field col s12','tipoInput' => 'input']))    
            ->add('imagen', FileType::class, [
                'label' => 'Imagenes JPG/PNG',
                // unmapped means that this field is not associated to any entity property
                //sin asignar significa que este campo no está asociado a ninguna propiedad de entidad
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                //hazlo opcional para que no tengas que volver a cargar el archivo PDF
                // every time you edit the Product details
                //cada vez que editas los detalles del producto
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'attr' => array('class'=>'browser-default','tipoInput' => 'file'),
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpe',
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Por favor suba una Imagen JPG o PNG correcta',
                    ])
                ],
            ])
            ->add('save', SubmitType::class,array('label'=>'Guardar','attr' => ['class' => 'waves-effect waves-light btn colorOficial white-text','tipoInput' => 'button'])); 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //
        ]);
    }
}
