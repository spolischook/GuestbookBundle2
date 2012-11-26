<?php

namespace Serge\GuestbookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GuestbookBundle:Default:index.html.twig', array('name' => $name));
    }
}
