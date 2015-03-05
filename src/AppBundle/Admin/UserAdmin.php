<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends Admin
{
    protected $baseRouteName = 'admin_user';
    protected $baseRoutePattern = '/app/user';

    public function configureFormFields(FormMapper $mapper)
    {
        $mapper
            ->add('name')
            ->add('email')
            ->add('password', 'password')
            ->add('roles', 'sonata_type_model', array(
                'class' => 'AppBundle\Entity\Role',
                'property_path' => 'name' 
            ))
        ;
    }

    public function toString($object)
    {
        return $object instanceof User
        ? $object->getName()
        : 'New User';
    }
}
