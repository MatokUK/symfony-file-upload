<?php

namespace Matok\Bundle\CloudBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function uploadAction(Request $request)
    {
        return $this->render('CloudBundle:default:index.html.twig', [

        ]);
    }
}
