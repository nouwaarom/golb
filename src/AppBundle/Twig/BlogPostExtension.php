<?php

namespace AppBundle\Twig;

class BlogPostExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('slugify', array($this, 'slugify')),
        );
    }

    public function slugify($text)
    {
        return strtolower(trim(preg_replace('/\W+/', '-', $text), '-'));
    }

    public function getName()
    {
        return 'blog_post';
    }
}
