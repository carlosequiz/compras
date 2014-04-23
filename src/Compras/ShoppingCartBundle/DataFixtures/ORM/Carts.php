<?php

namespace Compras\OfertaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Compras\ShoppingCartBundle\Entity\Cart;
use Compras\ShoppingCartBundle\Entity\CartItem;

/**
 * Fixtures de la entidad Cart.
 */
class Carts extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 50;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $productos = $manager->getRepository('CompraBundle:Producto')->findAll();
        
        for ($j=1; $j<=20; $j++) {
                
            $cart = new Cart();

            $cart->setItemsTotal(2);
            $cart->setEstado(1);
            $cart->setCreatedAt();
            $cart->setUpdatedAt();
            $cart->setDeletedAt();
            
            $manager->persist($cart);
            
            $cartItem = new CartItem();
            $cartItem->setCantidad(1);
            $cartItem->setCart($cart);
      
            $producto = $productos[array_rand($productos)];
            $cartItem->setProducto($producto);
            
            $cartItem->setPrecioUnitario(10.5);

            $manager->persist($cartItem);
            
            $cartItem = new CartItem();
            $cartItem->setCantidad(2);
            $cartItem->setCart($cart);
      
            $producto = $productos[array_rand($productos)];
            $cartItem->setProducto($producto);
            
            $cartItem->setPrecioUnitario(15.5);

            $manager->persist($cartItem);
            
            $manager->flush();
        }
    }
}
