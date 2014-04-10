<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este archivo pertenece a la aplicación de prueba Cupon.
 * El código fuente de la aplicación incluye un archivo llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace Compras\CompraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Compras\CompraBundle\Entity\Tienda;

/**
 * Fixtures de la entidad Tienda.
 * Crea entre 2 y 5 tiendas con información muy realista.
 */
class Tiendas extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 20;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            
            $tienda = new Tienda();

            $tienda->setNombre($this->getNombre());

            $tienda->setLogin('tienda'.$i);
            $tienda->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

            $passwordEnClaro = 'tienda'.$i;
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($tienda);
            $passwordCodificado = $encoder->encodePassword($passwordEnClaro, $tienda->getSalt());
            $tienda->setPassword($passwordCodificado);

            $tienda->setDireccion($this->getDireccion());

            $manager->persist($tienda);

        }

        $manager->flush();
    }

    /**
     * Generador aleatorio de nombres de tiendas
     *
     * @return string Nombre aleatorio generado para la tienda.
     */
    private function getNombre()
    {
        $prefijos = array('Restaurante', 'Cafetería', 'Bar', 'Pub', 'Pizza', 'Burger');
        $nombres = array(
            'Lorem ipsum', 'Sit amet', 'Consectetur', 'Adipiscing elit',
            'Nec sapien', 'Tincidunt', 'Facilisis', 'Nulla scelerisque',
            'Blandit ligula', 'Eget', 'Hendrerit', 'Malesuada', 'Enim sit'
        );

        return $prefijos[array_rand($prefijos)].' '.$nombres[array_rand($nombres)];
    }

    /**
     * Generador aleatorio de direcciones de tiendas
     *
     * @return  string Dirección aleatoria generada para la tienda.
     */
    private function getDireccion()
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

        $numeroFrases = rand(3, 6);

        return implode(' ', array_rand($frases, $numeroFrases));
    }
}
