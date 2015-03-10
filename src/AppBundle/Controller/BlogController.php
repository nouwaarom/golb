<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/post/{id}", name="show_blog_post")
     * @Security("is_granted('view', blogpost)")
     */
    public function showAction(BlogPost $blogpost)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT c
            FROM AppBundle:Comment c
            WHERE c.reactionTo = :post
            ORDER BY c.publishDate DESC'
        )->setParameter('post', $blogpost);

        $comments = $query->getResult();

        return $this->render('blog/single.html.twig', array(
            'post' => $blogpost,
            'comments' => $comments,
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
            ->add('title', 'text', array(
                'label' => false,
                'attr' => array(
                    'class' => 'new-post-form',
                    'placeholder' => 'Title',
                )
            ))
            ->add('content', 'textarea', array(
                'label' => false,
                'attr' => array(
                    'class' => 'new-post-form',
                    'placeholder'=> 'Story',
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Post',
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            
            //set the currently logged in user as author
            $user = $this->get('security.context')->getToken()->getUser();
            $post->setAuthor($user);

            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('blog/new.html.twig', array(
            'form' => $form->createView(),
        ));
     }

    /**
     * @Route("/edit/{id}", name="edit_blog_post")
     * @Security("is_granted('edit', blogpost)")
     */
     public function editAction(BlogPost $blogpost, Request $request)
     {
        $form = $this->CreateFormBuilder($blogpost)
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->add('save', 'submit', array('label' => 'Post'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($blogpost);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('blog/new.html.twig', array(
            'form' => $form->createView(),
        ));
     }
}
