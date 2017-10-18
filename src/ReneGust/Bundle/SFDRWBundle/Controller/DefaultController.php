<?php

namespace ReneGust\Bundle\SFDRWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ReneGustSFDRWBundle:Default:index.html.twig');
    }
}
