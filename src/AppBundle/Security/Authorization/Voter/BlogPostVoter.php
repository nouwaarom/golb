<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class BlogPostVoter implements VoterInterface
{
    const VIEW = 'view';
    const EDIT = 'edit';

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::VIEW, 
            self::EDIT,
        ));
    }

    public function supportsClass($class)
    {
        $supportedClass = 'AppBundle\Entity\BlogPost';

        return $supportedClass === $class;
    }

    public function vote(TokenInterface $token, $blogpost, array $attributes)
    {
        //check if the class of this object is supported
        if(!$this->supportsClass(get_class($blogpost)))
        {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        //check if the given attribute is covered
        $attribute = $attributes[0];
        if(!$this->supportsAttribute($attribute))
        {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();
        if(!$user instanceof UserInterface)
        {
            return VoterInterface::ACCESS_DENIED;
        }

        switch($attribute)
        {
            //TODO create private posts
            case self::VIEW:
                return VoterInterface::ACCESS_GRANTED;
                break;

            case self::EDIT:
                //first check if the post even has an author
                if($blogpost->getAuthor())
                {
                    if($user->getName() === $blogpost->getAuthor()->getName())
                    {
                        return VoterInterface::ACCESS_GRANTED;
                    }
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
