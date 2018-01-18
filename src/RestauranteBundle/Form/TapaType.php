<?php

namespace RestauranteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TapaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', TextType::class, array('label' => 'Nombre de la tapa', 'attr' => array('class' => 'input')))
        ->add('descripcion', TextType::class, array('label' => 'Descripción de la tapa', 'attr' => array('class' => 'input')))
        ->add('fechaCreacion', DateType::class, array('widget' => 'choice','attr' => ['class' => 'select']))
        ->add('precio', NumberType::class, array('attr' => array('class' => 'input')))
        ->add('foto', TextType::class, array('label' => 'Foto(URL)', 'attr' => array('class' => 'input')))
        ->add('guardar', SubmitType::class, array('attr' => array('class' => 'submit')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RestauranteBundle\Entity\Tapa'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'restaurantebundle_tapa';
    }


}
