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
        ;
    }

    protected function configureListFields(ListMapper $mapper)
    {
        $configureFormFieldsmapper
            ->addIdentifier('title')
            ->add('publishDate')
        ;
    }

    public function toString($object)
    {
        return $object instanceof BlogPost
            ? $object->getTitle()
            : 'New Blog Post';
    }
}
