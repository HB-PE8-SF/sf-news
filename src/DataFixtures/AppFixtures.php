<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $article = new Article();
        $article
            ->setTitle("La révélation de Nabil")
            ->setContent("highway anywhere best whenever explore tobacco forest driving square labor realize individual wheel ago involved beneath problem tent invented ball swept roof raw pencil")
            ->setVisible(true)
            ->setCreatedAt(new DateTime());

        $manager->persist($article);
        $manager->flush();
    }
}
