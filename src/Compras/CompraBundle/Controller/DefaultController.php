<?php

namespace Compras\CompraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Compras\CompraBundle\Entity\Orden;
use Compras\CompraBundle\Entity\OrdenItem;

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
    
    public function verProductosAction()
    {
        return $this->render('CompraBundle:Default:ver_productos.html.twig', array());
    }
    
    public function listarAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        
        $productos = $em->getRepository('CompraBundle:Producto')->findAll();
        
        return $this->render(
                    'CompraBundle:Default:listar.html.twig', array(
                    'productos' => $productos
        ));
    }
    
    /**
     * Muestra el formulario de búsqueda de productos
     *
     */
    public function buscarProductoAction()
    {
        $peticion = $this->getRequest();
        $em = $this->get('doctrine.orm.entity_manager');

        $productos = $em->getRepository('CompraBundle:Producto')->getProductosByNombre($peticion->get("buscar"));
        
        return $this->render(
                    'CompraBundle:Default:listaProductos.html.twig', array(
                    'productos' => $productos
        ));
        
    }
    
    /**
     * Permite revisar una orden antes de crearla
     *
     */
    public function reviewOrdenAction($id)
    {   
        $usuario = $this->get('security.context')->getToken()->getUser();
        $cart_id = $id;

        // Solo pueden comprar los usuarios registrados y logueados
        if (null == $usuario || !$this->get('security.context')->isGranted('ROLE_USUARIO')) {
            $this->get('session')->getFlashBag()->add('info',
                'Antes de comprar debes registrarte o conectarte con tu usuario y contraseña.'
            );

            return $this->redirect($this->generateUrl('usuario_login'));
        }
        
        $em = $this->get('doctrine.orm.entity_manager');
        
        $items = $em->getRepository('ShoppingCartBundle:Cart')->findCartItemsReview($cart_id);
                
        if(!$items)
        {
            throw new NotFoundHttpException('Ocurrió un error en la búsqueda del carrito de compras!');
        }
        
        return $this->render('CompraBundle:Default:reviewOrden.html.twig', array(
            'items' => $items,
        ));
    }
    
    /**
     * Crear una orden
     *
     */
    public function createOrdenAction($id)
    {   
        $usuario = $this->get('security.context')->getToken()->getUser();
        $cart_id = $id;

        // Solo pueden comprar los usuarios registrados y logueados
        if (null == $usuario || !$this->get('security.context')->isGranted('ROLE_USUARIO')) {
            $this->get('session')->getFlashBag()->add('info',
                'Antes de comprar debes registrarte o conectarte con tu usuario y contraseña.'
            );

            return $this->redirect($this->generateUrl('usuario_login'));
        }
        
        $em = $this->get('doctrine.orm.entity_manager');
        
        $items = $em->getRepository('ShoppingCartBundle:Cart')->findCartItemsReview($cart_id);
                
        if(!$items)
        {
            throw new NotFoundHttpException('Ocurrió un error en la creación de la orden de compras!');
        }
        
        $em->getConnection()->beginTransaction(); // suspend auto-commit
        try {
            $order = new Orden();

            $order->setDireccionEnvioId(1);
            $order->setDireccionFacturacionId(1);
            $order->setPagoId(1);
            $order->setUsuario($usuario);
            $order->setNumero('xxxx-111');
            $order->setEstadoId(1);
            $order->setItemsTotal(count($items));
            $order->setCreatedAt();
            $order->setMoneda('BSF');

            $em->persist($order);
            
            foreach ($items as $item)
            {
                $orderItem = new OrdenItem();
                
                $orderItem->setOrden($order);
                $orderItem->setCantidad($item->getCantidad());
                $orderItem->setPrecioUnitario($item->getPrecioUnitario());
                
                $em->persist($orderItem);
            }

            $em->flush();
            
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return $this->render('CompraBundle:Default:successOrden.html.twig', array(
            'items' => $items,
        ));
    }
}
