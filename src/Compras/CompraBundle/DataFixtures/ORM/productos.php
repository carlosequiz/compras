<?php

namespace Compras\CompraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Compras\CompraBundle\Entity\Producto;

/**
 * Fixtures de la entidad Producto.
 * Crea para cada tienda 20 productos con información muy realista.
 */
class Productos extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 30;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // Obtener todas las tiendas y ciudades de la base de datos
        $tiendas = $manager->getRepository('CompraBundle:Tienda')->findAll();

        for ($j=1; $j<=100; $j++) {
                
            $producto = new Producto();

            $producto->setNombre($this->getNombre());
            $producto->setDescripcion($this->getDescripcion());
            $producto->setRutaFoto('foto'.rand(1,20).'.jpg');
            $producto->setPrecio(number_format(rand(100, 10000)/100, 2));
            $producto->setDescuento($producto->getPrecio() * (rand(10, 70)/100));

            // Una oferta se publica hoy, el resto se reparte entre el pasado y el futuro
            if (1 == $j) {
                $fecha = 'today';
            } elseif ($j < 10) {
                $fecha = 'now - '.($j-1).' days';
            } else {
                $fecha = 'now + '.($j - 10 + 1).' days';
            }

            $fechaPublicacion = new \DateTime($fecha);
            $fechaPublicacion->setTime(23, 59, 59);
            
            // Se debe clonar el valor de la fechaPublicacion porque si se usa directamente
            // el método ->add(), se modificaría el valor original, que no se guarda en la BD
            // hasta que se hace el ->flush()
            $fechaExpiracion = clone $fechaPublicacion;
            $fechaExpiracion->add(\DateInterval::createFromDateString('24 hours'));

            $producto->setFechaPublicacion($fechaPublicacion);
            $producto->setFechaExpiracion($fechaExpiracion);

            // Seleccionar aleatoriamente una tienda que pertenezca a la ciudad anterior
            $tienda = $tiendas[array_rand($tiendas)];
            $producto->setTienda($tienda);

            $manager->persist($producto);
            $manager->flush();
        }
    }

    /**
     * Generador aleatorio de nombres de ofertas.
     *
     * @return string Nombre/título aletorio generado para la oferta.
     */
    private function getNombre()
    {
        $palabras = array_flip(array(
            'Lorem', 'Ipsum', 'Sitamet', 'Et', 'At', 'Sed', 'Aut', 'Vel', 'Ut',
            'Dum', 'Tincidunt', 'Facilisis', 'Nulla', 'Scelerisque', 'Blandit',
            'Ligula', 'Eget', 'Drerit', 'Malesuada', 'Enimsit', 'Libero',
            'Penatibus', 'Imperdiet', 'Pendisse', 'Vulputae', 'Natoque',
            'Aliquam', 'Dapibus', 'Lacinia'
        ));

        $numeroPalabras = rand(4, 8);

        return implode(' ', array_rand($palabras, $numeroPalabras));
    }

    /**
     * Generador aleatorio de descripciones de ofertas.
     *
     * @return string Descripción aletoria generada para la oferta.
     */
    private function getDescripcion()
    {
        $frases = array_flip(array(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Mauris ultricies nunc nec sapien tincidunt facilisis.',
            'Nulla scelerisque blandit ligula eget hendrerit.',
            'Sed malesuada, enim sit amet ultricies semper, elit leo lacinia massa, in tempus nisl ipsum quis libero.',
            'Aliquam molestie neque non augue molestie bibendum.',
            'Pellentesque ultricies erat ac lorem pharetra vulputate.',
            'Donec dapibus blandit odio, in auctor turpis commodo ut.',
            'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
            'Nam rhoncus lorem sed libero hendrerit accumsan.',
            'Maecenas non erat eu justo rutrum condimentum.',
            'Suspendisse leo tortor, tempus in lacinia sit amet, varius eu urna.',
            'Phasellus eu leo tellus, et accumsan libero.',
            'Pellentesque fringilla ipsum nec justo tempus elementum.',
            'Aliquam dapibus metus aliquam ante lacinia blandit.',
            'Donec ornare lacus vitae dolor imperdiet vitae ultricies nibh congue.',
        ));

        $numeroFrases = rand(4, 7);

        return implode("\n", array_rand($frases, $numeroFrases));
    }
}
