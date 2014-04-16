<?php

namespace Compras\ShoppingCartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function summaryAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        
        $cart = $em->getRepository('ShoppingCartBundle:Cart')->findCart();
        
        return $this->render(
                    'ShoppingCartBundle:Default:summary.html.twig', array(
                    'cart' => $cart
        ));
    }
}
