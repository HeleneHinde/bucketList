<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $generator = Factory::create('fr_FR');

        for ($i=0;$i<20;$i++){
            $wish = new Wish();
            $wish ->setAuthor($generator->word);
            $wish ->setTitle($generator->word.$i);
            $wish ->setDescription($generator->word);
            $wish ->setIsPublished($generator->boolean());
            $wish->setDateCreated($generator->dateTimeBetween('-10 years','now'));
        $manager->persist($wish);
        }

        $manager->flush();
    }
}
