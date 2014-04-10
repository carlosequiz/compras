<?php

namespace Compras\ShoppingCartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function summaryAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        
        $items = $em->getRepository('ShoppingCartBundle:CartItem')->findAll();
        
        return $this->render(
                    'ShoppingCartBundle:Default:summary.html.twig', array(
                    'items' => $items
        ));
    }
}
