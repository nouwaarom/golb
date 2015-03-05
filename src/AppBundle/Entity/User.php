<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64) 
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email; 

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     */
    private $roles; 

    /**
     * @ORM\OneToMany(targetEntity="BlogPost", mappedBy="author")
     */
    private $articles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

   //serializable 
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->name,
            $this->password
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->name,
            $this->password
        ) = unserialize($serialized);
    }

    //userinterface
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function addRole(Role $role)
    {
        $this->roles[] = $role;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUsername()
    {
        return $this->getName();
    }

    public function setName($name)
    {
       $this->name = $name; 
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getArticles()
    {
        return $this->articles->toArray();
    }

    public function eraseCredentials()
    {
       //TODO: remove object from database 
    }
}

