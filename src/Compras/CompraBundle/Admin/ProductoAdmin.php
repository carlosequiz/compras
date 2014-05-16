<?php

namespace Compras\CompraBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class ProductoAdmin extends Admin
{
    protected function configureListFields(ListMapper $mapper)
    {
        $mapper
            ->addIdentifier('nombre', null, array('label' => 'Nombre'))
            ->add('descripcion')
            ->add('precio')
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $mapper)
    {
        $mapper
            ->add('nombre')
            ->add('descripcion')
        ;
    }
    
    protected function configureFormFields(FormMapper $mapper)
    {
        $mapper
            ->with('Datos básicos')
                ->add('nombre')
                ->add('descripcion')
            ->end()
            ->with('Foto')
                ->add('foto', 'file')
            ->end()
            ->with('Financieros')
                ->add('precio')
                ->add('descuento')
                ->add('fechaPublicacion', 'date')
                ->add('fechaExpiracion', 'date')
                ->add('tienda')
            ->end()
        ;
    }
}