<?php

namespace eDemy\DesignBundle\Controller;

use eDemy\MainBundle\Controller\BaseController;
use eDemy\MainBundle\Event\ContentEvent;

class DesignController extends BaseController
{
    public static function getSubscribedEvents()
    {
        return self::getSubscriptions('design', [], array(
            'edemy_design'  => array('onDesign', 0),
        ));
    }

    public function __construct()
    {
        parent::__construct();
        
    }

    public function onDesign(ContentEvent $event)
    {
        $form = $this->get('form.factory')
            ->createBuilder()
            ->add('actividad', 'text')
            ->add('descripcion', 'textarea')
            ->add('fecha', 'date')
            ->add('precio', 'text')
            ->add('profesor', 'text')
            ->add('save', 'submit', array('label' => 'Crear Cartel'))
            ->getForm();

        $form->handleRequest($this->getCurrentRequest());

        if ($form->isValid()) {
            $this->addEventContent($event, "create.html.twig", array(
                'data' => $form->getData(),
            ));
        } else {
            $this->addEventContent($event, "design.html.twig", array(
                'form' => $form->createView()
            ));
        }
        
        return true;
    }
}
