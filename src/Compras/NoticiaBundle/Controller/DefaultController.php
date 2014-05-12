<?php

namespace Compras\NoticiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    // tenemos un array con los datos básicos
    private $array_notice = array(
        array(
            'title' => 'Titulo de noticia 0',
            'content' => 'Contenido de noticia 0'
        ),
        array(
            'title' => 'Titulo de noticia 1',
            'content' => 'Contenido de noticia 1'
        ),
    );
    
    public function indexAction()
    {
        // suponiendo que obtenemos del modelo el listado de noticias
        return $this->render('NoticiaBundle:Default:index.html.twig', array(
            'notices' => $this->array_notice
        ));
    }
    
    public function noticeViewAction($notice_id)
    {
        //obtenemos la noticia del modelo, en este ejemplo proviene de un array
        $notice = $this->array_notice[$notice_id];
        return $this->render('NoticiaBundle:Default:noticeView.html.twig', array(
            'notice' => $notice
        ));
    }
}
