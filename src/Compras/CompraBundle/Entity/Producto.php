<?php

namespace Compras\CompraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Compras\CompraBundle\Util\Util;
use Symfony\Component\Validator\Constraints AS Assert;

/**
 * Producto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Compras\CompraBundle\Entity\ProductoRepository")
 */
class Producto
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="rutafoto", type="string", length=255, nullable=true)
     */
    private $rutafoto;
    
    /**
     * @Assert\Image(maxSize = "500k")
     */
    protected $foto;

    /**
     * @var decimal
     *
     * @ORM\Column(name="precio", type="decimal", scale=2)
     * @Assert\Range(min = 0)
     */
    private $precio;

    /**
     * @var decimal
     *
     * @ORM\Column(name="descuento", type="decimal", scale=2, nullable=true)
     */
    private $descuento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_publicacion", type="datetime")
     */
    private $fechaPublicacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_expiracion", type="datetime", nullable=true)
     */
    private $fechaExpiracion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Compras\CompraBundle\Entity\Tienda")
     */
    private $tienda;

    
    public function __toString() 
    {
        return $this->getNombre();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Producto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->slug = Util::getSlug($nombre);

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Producto
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Producto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set rutafoto
     *
     * @param string $rutafoto
     * @return Producto
     */
    public function setRutafoto($rutafoto)
    {
        $this->rutafoto = $rutafoto;

        return $this;
    }

    /**
     * Get rutafoto
     *
     * @return string 
     */
    public function getRutafoto()
    {
        return $this->rutafoto;
    }
    
    /**
     * Set foto.
     *
     * @param UploadedFile $foto
     */
    public function setFoto(UploadedFile $foto = null)
    {
        $this->foto = $foto;
    }

    /**
     * Get foto.
     *
     * @return UploadedFile
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return Producto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set descuento
     *
     * @param string $descuento
     * @return Producto
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return string 
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set fechaPublicacion
     *
     * @param \DateTime $fechaPublicacion
     * @return Producto
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
        $this->fechaPublicacion = $fechaPublicacion;

        return $this;
    }

    /**
     * Get fechaPublicacion
     *
     * @return \DateTime 
     */
    public function getFechaPublicacion()
    {
        return $this->fechaPublicacion;
    }

    /**
     * Set fechaExpiracion
     *
     * @param \DateTime $fechaExpiracion
     * @return Producto
     */
    public function setFechaExpiracion($fechaExpiracion)
    {
        $this->fechaExpiracion = $fechaExpiracion;

        return $this;
    }

    /**
     * Get fechaExpiracion
     *
     * @return \DateTime 
     */
    public function getFechaExpiracion()
    {
        return $this->fechaExpiracion;
    }
    
    /**
     * Set tienda
     *
     * @param \Compras\CompraBundle\Entity\Tienda $tienda
     */
    public function setTienda(\Compras\CompraBundle\Entity\Tienda $tienda)
    {
        $this->tienda = $tienda;
    }

    /**
     * Get tienda
     *
     * @return \Compras\CompraBundle\Entity\Tienda
     */
    public function getTiendaId()
    {
        return $this->tienda;
    }

    /**
     * Get tienda
     *
     * @return \Compras\CompraBundle\Entity\Tienda 
     */
    public function getTienda()
    {
        return $this->tienda;
    }
}
