<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\BlogPost;

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

    /**
     * @Route("/post/{id}/{slug}", name="show_blog_post")
     */
    public function showAction(BlogPost $blogPost)
    {
        return $this->render('blog/single.html.twig', array(
            'post' => $blogPost,
        ));
    }
}
