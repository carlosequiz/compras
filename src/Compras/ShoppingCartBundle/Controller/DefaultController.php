<?php

namespace Compras\ShoppingCartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Compras\ShoppingCartBundle\Entity\Cart;
use Compras\ShoppingCartBundle\Entity\CartItem;

class DefaultController extends Controller
{
    
    public function additemAction($id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $producto_id = $id;

        // Solo pueden comprar los usuarios registrados y logueados
        if (null == $usuario || !$this->get('security.context')->isGranted('ROLE_USUARIO')) {
            $this->get('session')->getFlashBag()->add('info',
                'Antes de comprar debes registrarte o conectarte con tu usuario y contraseña.'
            );

            return $this->redirect($this->generateUrl('usuario_login'));
        }
        
        $em = $this->get('doctrine.orm.entity_manager');
        
        $cart = $em->getRepository('ShoppingCartBundle:Cart')->findOneBy(
                                              array('usuario' => $usuario->getId(),
                                                     'estado' => 1));
        
        $producto = $em->getRepository('CompraBundle:Producto')->find($producto_id);
        
        
        if(null == $cart)
        {
            $cart = new Cart();
            
            $cart->setItemsTotal(0);
            $cart->setEstado(1);
            $cart->setUsuario($usuario);
            
            $em->persist($cart);
            $em->flush();
        }
        
        
        $cartItem = new CartItem();
        
        $cartItem->setCart($cart);
        $cartItem->setProducto($producto);
        $cartItem->setCantidad(1);
        $cartItem->setPrecioUnitario(12.2);
        
        $em->persist($cartItem);
        $em->flush();
        
        $total = $cart->getItemsTotal();
        $cart->setItemsTotal($total++);
        
        $em->persist($cart);
        $em->flush();
        
        return $this->redirect($this->generateUrl('shopping_cart_summary'));
    }
    
    public function summaryAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        
        $usuario = $this->get('security.context')->getToken()->getUser();
        
        // Solo pueden comprar los usuarios registrados y logueados
        if (null == $usuario || !$this->get('security.context')->isGranted('ROLE_USUARIO')) {
            $this->get('session')->getFlashBag()->add('info',
                'Antes de comprar debes registrarte o conectarte con tu usuario y contraseña.'
            );

            return $this->redirect($this->generateUrl('usuario_login'));
        }
        
        $items = $em->getRepository('ShoppingCartBundle:Cart')->findCartItems($usuario->getId());
        //echo count($items); exit();
        
        return $this->render(
                    'ShoppingCartBundle:Default:summary.html.twig', array(
                    'items' => $items
        ));
    }
    
    
    public function removeitemAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $entity = $em->getRepository('ShoppingCartBundle:CartItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $em->remove($entity);
        $em->flush();
    
        return $this->redirect($this->generateUrl('shopping_cart_summary'));
    }

}
