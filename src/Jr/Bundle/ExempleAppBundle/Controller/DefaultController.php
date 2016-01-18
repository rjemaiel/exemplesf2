<?php

namespace Jr\Bundle\ExempleAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="index")
     * @Route("/home", name="home")
     * index
     */
    public function indexAction()
    {
        return $this->render('JrExempleAppBundle:Default:index.html.twig');
    }

}
