<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use AppBundle\Entity\BlogPost;
use Faker\Factory as FakerFactory;

class LoadBlogPostsData implements FixtureInterface
{
    public function load(ObjectManager $em)
    {
        $faker = FakerFactory::create();

        for ($i = 0; $i < 10; $i++) {
            $paragraph = '';
            for ($j = 0; $j < rand(2, 5); $j++) {
                $paragraph .= '<p>'.$faker->text(rand(3000, 4000)).'</p>';
            }

            $post = new BlogPost(
                rtrim($faker->sentence(), '.'),
                $paragraph,
                $faker->dateTimeThisDecade()
            );

            $em->persist($post);
        }

        $em->flush();
    }
}
