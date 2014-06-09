<?php

namespace Compras\CompraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Orden
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Compras\CompraBundle\Entity\OrdenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Orden
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
     * @ORM\Column(name="direccion_envio_id", type="integer", nullable=true)
     */
    private $direccionEnvioId;

    /**
     * @var integer
     *
     * @ORM\Column(name="direccion_facturacion_id", type="integer")
     */
    private $direccionFacturacionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pago_id", type="integer")
     */
    private $pagoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="coupon_id", type="integer", nullable=true)
     */
    private $couponId;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255)
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado_id", type="integer")
     */
    private $estadoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="itemsTotal", type="integer")
     */
    private $itemsTotal;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="completed_at", type="datetime", nullable=true)
     */
    private $completed_at;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="delete_at", type="datetime", nullable=true)
     */
    private $delete_at;

    /**
     * @var string
     *
     * @ORM\Column(name="moneda", type="string", length=3)
     */
    private $moneda;

    /**
     * @var string
     *
     * @ORM\Column(name="pago_estado", type="string", length=255, nullable=true)
     */
    private $pagoEstado;

    /**
     * @var string
     *
     * @ORM\Column(name="envio_estado", type="string", length=255, nullable=true)
     */
    private $envioEstado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Compras\UsuarioBundle\Entity\Usuario", inversedBy="ordenes")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    protected $usuario;
    
    /**
     * @ORM\OneToMany(targetEntity="OrdenItem", mappedBy="orden")
     */
    protected $items;

    
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }


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
     * Set direccionEnvioId
     *
     * @param integer $direccionEnvioId
     * @return Orden
     */
    public function setDireccionEnvioId($direccionEnvioId)
    {
        $this->direccionEnvioId = $direccionEnvioId;

        return $this;
    }

    /**
     * Get direccionEnvioId
     *
     * @return integer 
     */
    public function getDireccionEnvioId()
    {
        return $this->direccionEnvioId;
    }

    /**
     * Set direccionFacturacionId
     *
     * @param integer $direccionFacturacionId
     * @return Orden
     */
    public function setDireccionFacturacionId($direccionFacturacionId)
    {
        $this->direccionFacturacionId = $direccionFacturacionId;

        return $this;
    }

    /**
     * Get direccionFacturacionId
     *
     * @return integer 
     */
    public function getDireccionFacturacionId()
    {
        return $this->direccionFacturacionId;
    }

    /**
     * Set pagoId
     *
     * @param integer $pagoId
     * @return Orden
     */
    public function setPagoId($pagoId)
    {
        $this->pagoId = $pagoId;

        return $this;
    }

    /**
     * Get pagoId
     *
     * @return integer 
     */
    public function getPagoId()
    {
        return $this->pagoId;
    }

    /**
     * Set couponId
     *
     * @param integer $couponId
     * @return Orden
     */
    public function setCouponId($couponId)
    {
        $this->couponId = $couponId;

        return $this;
    }

    /**
     * Get couponId
     *
     * @return integer 
     */
    public function getCouponId()
    {
        return $this->couponId;
    }

    /**
     * Set usuarioId
     *
     * @param integer $usuarioId
     * @return Orden
     */
    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    /**
     * Get usuarioId
     *
     * @return integer 
     */
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Orden
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set estadoId
     *
     * @param integer $estadoId
     * @return Orden
     */
    public function setEstadoId($estadoId)
    {
        $this->estadoId = $estadoId;

        return $this;
    }

    /**
     * Get estadoId
     *
     * @return integer 
     */
    public function getEstadoId()
    {
        return $this->estadoId;
    }

    /**
     * Set itemsTotal
     *
     * @param integer $itemsTotal
     * @return Orden
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
     * Set completed_at
     *
     * @param \DateTime $createdAt
     * @return Orden
     */
    public function setCompletedAt($completedAt)
    {
    $this->completed_at = $createdAt;

        return $this;
    }

    /**
     * Get completed_at
     *
     * @return \DateTime 
     */
    public function getCompletedAt()
    {
        return $this->completed_at;
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
     * @ORM\PreUpdate
     * 
     * @return Orden
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at =  new \DateTime();

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
     * Set moneda
     *
     * @param string $moneda
     * @return Orden
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * Get moneda
     *
     * @return string 
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Set pagoEstado
     *
     * @param string $pagoEstado
     * @return Orden
     */
    public function setPagoEstado($pagoEstado)
    {
        $this->pagoEstado = $pagoEstado;

        return $this;
    }

    /**
     * Get pagoEstado
     *
     * @return string 
     */
    public function getPagoEstado()
    {
        return $this->pagoEstado;
    }

    /**
     * Set envioEstado
     *
     * @param string $envioEstado
     * @return Orden
     */
    public function setEnvioEstado($envioEstado)
    {
        $this->envioEstado = $envioEstado;

        return $this;
    }

    /**
     * Get envioEstado
     *
     * @return string 
     */
    public function getEnvioEstado()
    {
        return $this->envioEstado;
    }

    /**
     * Add items
     *
     * @param \Compras\CompraBundle\Entity\OrdenItem $items
     * @return Orden
     */
    public function addItem(\Compras\CompraBundle\Entity\OrdenItem $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \Compras\CompraBundle\Entity\OrdenItem $items
     */
    public function removeItem(\Compras\CompraBundle\Entity\OrdenItem $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set delete_at
     *
     * @param \DateTime $deleteAt
     * @return Orden
     */
    public function setDeleteAt($deleteAt)
    {
        $this->delete_at = $deleteAt;

        return $this;
    }

    /**
     * Get delete_at
     *
     * @return \DateTime 
     */
    public function getDeleteAt()
    {
        return $this->delete_at;
    }
    
    /**
     * Set usuario
     *
     * @param \Compras\UsuarioBundle\Entity\Usuario $usuario
     * @return Orden
     */
    public function setUsuario(\Compras\UsuarioBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Compras\UsuarioBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
