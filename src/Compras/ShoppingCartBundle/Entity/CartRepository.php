<?php

namespace Compras\ShoppingCartBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CartRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CartRepository extends EntityRepository
{
    public function findCart()
    {
        $em = $this->getEntityManager($id = 2);
        
        $consulta = $em->createQuery('
                SELECT c, i
                  FROM ShoppingCartBundle:Cart c
                  JOIN c.items i
                 WHERE c.id = :id
              ORDER BY i.cantidad DESC');
        
        //$consulta->setMaxResults();
        $consulta->setParameter('id', $id);
        
        return $consulta->getResult();
    }
}
