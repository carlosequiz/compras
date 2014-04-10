<?php

namespace Compras\UsuarioBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulario para crear entidades de tipo Usuario cuando los usuarios se
 * registran en el sitio.
 * Como se utiliza en la parte pública del sitio, algunas propiedades de
 * la entidad no se incluyen en el formulario.
 */
class UsuarioRegistroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellidos')
            ->add('email', 'email',  array('label' => 'Correo electrónico', 'attr' => array(
                'placeholder' => 'usuario@servidor',
            )))

            ->add('password', 'repeated', array(
                'type' => 'password',
                'label'=> 'Contraseña',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
//                'first_options'   => array('label' => 'Contraseña', 'attr' => array('class' => 'form-control')),
//                'second_options'  => array('label' => 'Repite Contraseña', 'attr' => array('class' => 'form-control')),
                'required'        => true
            ))

            ->add('direccion')
            ->add('permite_email', 'checkbox', array('required' => false))
            ->add('fecha_nacimiento', 'birthday', array(
                'years' => range(date('Y') - 18, date('Y') - 18 - 120)
            ))
                
            ->add('ci')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Compras\UsuarioBundle\Entity\Usuario',
            'validation_groups' => array('default', 'registro')
        ));
    }

    public function getName()
    {
        return 'frontend_usuario';
    }
}
