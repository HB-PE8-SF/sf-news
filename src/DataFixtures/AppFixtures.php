<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\ORM\Doctrine\Populator;

class AppFixtures extends Fixture
{
    private const NB_ARTICLES = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $populator = new Populator($faker, $manager);
        $populator->addEntity(Category::class, 10, [
            'name' => function () use ($faker) { return $faker->word(); }
        ]);
        $populator->addEntity(Article::class, 50);
        $populator->execute();
    }
}
