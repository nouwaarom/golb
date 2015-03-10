<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Comment;
use AppBundle\Entity\BlogPost;

class CommentController extends Controller
{
    /**
     * @Route("/{id}/comment", name="new_comment")
     */
    public function newAction(BlogPost $post, Request $request)
    {
        $comment = new Comment();

        $form = $this->createFormBuilder($comment)
            ->add('content', 'text')
            ->getForm();
            
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            
            //set the currently logged in user as author
            $user = $this->get('security.context')->getToken()->getUser();
            $comment->setAuthor($user);

            $comment->setReactionTo($post);

            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('show_blog_post', array(
                'id' => $post->getId()
            )));
        }

        return $this->render('comment/new.html.twig', array('form' => $form->createView()));
    }
}
