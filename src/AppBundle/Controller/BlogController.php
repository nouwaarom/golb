<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function listAction()
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:BlogPost')->findAll();

        return $this->render('blog/list.html.twig', array(
            'posts' => $posts,
        ));
    }
}
