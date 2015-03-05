<?php

namespace AppBundle\Admin;

use AppBundle\Entity\BlogPost;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BlogPostAdmin extends Admin
{
    protected $baseRouteName = 'admin_blog_post';
    protected $baseRoutePattern = '/app/blog_post';

    protected function configureFormFields(FormMapper $mapper)
    {
        $mapper
            ->add('title')
            ->add('content')
            ->add('publishDate')
            ->add('author', 'sonata_type_model', array(
                'class'=> 'AppBundle\Entity\User',
                'property' => 'name'
            ))
        ;
    }

    protected function configureListFields(ListMapper $mapper)
    {
        $mapper
            ->addIdentifier('title')
            ->add('publishDate')
            ->add('author')
        ;
    }

    public function toString($object)
    {
        return $object instanceof BlogPost
            ? $object->getTitle()
            : 'New Blog Post';
    }
}
