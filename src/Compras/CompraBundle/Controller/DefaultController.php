<?php

namespace Compras\CompraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Muestra la portada del sitio web
     *
     */
    public function portadaAction()
    {
        return $this->render('CompraBundle:Default:portada.html.twig');
    }
    
    
    /**
     * Muestra el formulario de contacto y también procesa el envío de emails
     *
     */
    public function contactoAction()
    {
        $peticion = $this->getRequest();

        // Se crea un formulario "in situ", sin clase asociada
        $formulario = $this->createFormBuilder()
            ->add('nombre', 'text', 
                    array(
                        'attr' => array(
                                    'placeholder' => 'Nombre y apellido',
                                    'autofocus'   => true
                                  ),
                        'required'  => true
                        ))

            ->add('remitente', 'email', array('attr' => array(
                'placeholder' => 'usuario@servidor'
            )))
                
            ->add('mensaje', 'textarea',
                    array(
                        'attr' => array(
                                    'placeholder' => 'Mensaje',
                                    'rows' => 5
                                  ),
                        'required' => true
                    ))
            ->getForm()
        ;

        $formulario->handleRequest($peticion);

        if ($formulario->isValid()) {
            $datos = $formulario->getData();

            $contenido = sprintf(" Remitente: %s \n\n Mensaje: %s \n\n Navegador: %s \n Dirección IP: %s \n",
                $datos['remitente'],
                htmlspecialchars($datos['mensaje']),
                $peticion->server->get('HTTP_USER_AGENT'),
                $peticion->server->get('REMOTE_ADDR')
            );

            $mensaje = \Swift_Message::newInstance()
                ->setSubject('Contacto')
                ->setFrom($datos['remitente'])
                ->setTo('standardit.desarrollo@gmail.com')
                ->setBody($contenido)
            ;

            $this->get('mailer')->send($mensaje);

            $this->get('session')->getFlashBag()->set('info',
                'Tu mensaje se ha enviado correctamente.'
            );

            return $this->redirect($this->generateUrl('portada'));
        }

        return $this->render('CompraBundle:Default:contacto.html.twig', array(
            'formulario' => $formulario->createView(),
        ));
    }
    
    public function listaProductosAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        
        $productos = $em->getRepository('CompraBundle:Producto')->findAll();
        
        return $this->render(
                    'CompraBundle:Default:listaProductos.html.twig', array(
                    'productos' => $productos
        ));
    }
    
    public function recentProductosListAction($max = 3)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        
        $productos = $em->getRepository('CompraBundle:Producto')->getRecentProductos($max);
        
        return $this->render(
                    'CompraBundle:Default:recentProductsList.html.twig', array(
                    'productos' => $productos
        ));

    }
    
    public function productoAction($slug)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        
        $producto = $em->getRepository('CompraBundle:Producto')->findProducto($slug);
        
        if (!$producto) {
            throw $this->createNotFoundException('No existe el producto');
        }
        
        return $this->render('CompraBundle:Default:detalle.html.twig', array(
            'producto'       => $producto
        ));
    }
}
