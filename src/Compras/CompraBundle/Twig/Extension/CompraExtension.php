<?php

namespace Compras\CompraBundle\Twig\Extension;

class CompraExtension extends \Twig_Extension 
{
    public function getFilters()
    {
        return array(
            'mostrar_como_lista' => new \Twig_Filter_Method($this, 'mostrarComoLista', array('is_safe' => array('html')))
        );
    }
    
    public function mostrarComoLista($value, $tipo='ul')
    {
        $html = "<".$tipo.">\n";
        $html .= " <li>".str_replace("\n", "</li>\n <li>", $value)."</li>\n";
        $html .= "</".$tipo.">\n";
        
        return $html;
    }
    
    public function descuento($precio, $descuento, $decimales = 0)
    {
        if (!is_numeric($precio) || !is_numeric($descuento)) {
            return '-';
        }
        
        if ($descuento == 0 || $descuento == null) {
            return '0%';
        }
        
        $precio_original = $precio + $descuento;
        $porcentaje = ($descuento / $precio_original) * 100;
        return '-' . number_format($porcentaje, $decimales) . '%';
    }
 
    
    public function getFunctions()
    {
        return array(
            'descuento' => new \Twig_Function_Method($this, 'descuento')
        );
    }
    
    public function getName()
    {
        return 'compra';
    }
    
}
