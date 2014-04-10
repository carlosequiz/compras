<?php

namespace Compras\CompraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdenItem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class OrdenItem
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
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="precio_unitario", type="decimal")
     */
    private $precioUnitario;
    
    /**
     * @ORM\ManyToOne(targetEntity="Orden", inversedBy="items")
     * @ORM\JoinColumn(name="orden_id", referencedColumnName="id")
     */
    protected $orden;


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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return OrdenItem
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set precioUnitario
     *
     * @param string $precioUnitario
     * @return OrdenItem
     */
    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;

        return $this;
    }

    /**
     * Get precioUnitario
     *
     * @return string 
     */
    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    /**
     * Set orden
     *
     * @param \Compras\CompraBundle\Entity\Orden $orden
     * @return OrdenItem
     */
    public function setOrden(\Compras\CompraBundle\Entity\Orden $orden = null)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return \Compras\CompraBundle\Entity\Orden 
     */
    public function getOrden()
    {
        return $this->orden;
    }
}
