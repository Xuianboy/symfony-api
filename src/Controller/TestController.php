<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/test", name="test")
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }

}
