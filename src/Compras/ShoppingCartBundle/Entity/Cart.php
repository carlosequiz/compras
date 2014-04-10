<?php

namespace Compras\ShoppingCartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Compras\ShoppingCartBundle\Entity\CartRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Cart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="itemsTotal", type="integer")
     */
    private $itemsTotal;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="created_at", type="datetime")
     *
     */
    private $created_at;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="updated_at", type="datetime")
     *
     */
    private $updated_at;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="deleted_at", type="datetime")
     *
     */
    private $deleted_at;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer")
     */
    private $estado;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set itemsTotal
     *
     * @param integer $itemsTotal
     * @return Cart
     */
    public function setItemsTotal($itemsTotal)
    {
        $this->itemsTotal = $itemsTotal;

        return $this;
    }

    /**
     * Get itemsTotal
     *
     * @return integer 
     */
    public function getItemsTotal()
    {
        return $this->itemsTotal;
    }
    
    /**
     * Set created_at
     *
     * @ORM\PrePersist
     * @return Orden
     */
    public function setCreatedAt()
    {
        $this->created_at = new \DateTime();

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @ORM\PreUpdate
     * @return Orden
     */
    public function setUpdatedAt()
    {
        $this->updated_at = new \DateTime();

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set deleted_at
     *
     * @ORM\PreUpdate
     * @return Orden
     */
    public function setDeletedAt()
    {
        $this->deleted_at = new \DateTime();

        return $this;
    }

    /**
     * Get deleted_at
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return Cart
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
