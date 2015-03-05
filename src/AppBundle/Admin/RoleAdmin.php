<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class RoleAdmin extends Admin
{
    protected $baseRouteName = 'admin_role';
    protected $baseRoutePattern = '/app/role';

    public function configureFormFields(FormMapper $mapper)
    {
        $mapper
            ->add('name')
            ->add('role')
        ;
    }

    public function configureListFields(ListMapper $mapper)
    {
        $mapper->add('name');
    }


    public function toString($object)
    {
        return $object instanceof Role
            ? $object->getName()
            : 'New Role';
    }
}
