<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\BlogPost;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/new", name="new_blog_post")
     */
     public function newAction(Request $request)
     {
        $post = new BlogPost();
        $post->setPublishDate(new \DateTime('now'));

        $form = $this->CreateFormBuilder($post)
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->add('save', 'submit', array('label' => 'Post'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('blog/new.html.twig', array(
            'form' => $form->createView(),
        ));
     }
}
