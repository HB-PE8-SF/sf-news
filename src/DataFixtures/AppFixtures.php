<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_ARTICLES = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realText(50))
                ->setContent($faker->realTextBetween(500, 700))
                ->setVisible($faker->boolean(80))
                ->setCreatedAt($faker->dateTimeBetween('-2 years'));

            $manager->persist($article);
        }

        $manager->flush();
    }
}
