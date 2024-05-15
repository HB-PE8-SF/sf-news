<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_ARTICLES = 50;

    private const CATEGORIES = [
        'Front-end'  => '💄',
        'Back-end'   => '🖥️',
        'Full-Stack' => '👑',
        'Framework'  => '❇️',
        'API'        => '🔌',
        'DevOps'     => '🧬'
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $categories = [];

        foreach (self::CATEGORIES as $categoryName => $categoryEmoji) {
            $category = new Category();
            $category
                ->setName($categoryName)
                ->setEmoji($categoryEmoji);
            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->realText(50))
                ->setContent($faker->realTextBetween(500, 700))
                ->setVisible($faker->boolean(80))
                ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                ->setCategory($faker->randomElement($categories))
                ->setCover('default.jpg');

            $manager->persist($article);
        }

        $user = new User();
        $user
            ->setEmail("user@test.com")
            ->setPassword("user1234");

        $manager->persist($user);

        $admin = new User();

        $admin
            ->setEmail("admin@test.com")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword("admin1234");

        $manager->persist($admin);

        $apiToken = new ApiToken();
        $apiToken
            ->setName("Trevor Baldwin")
            ->setToken("jJcXeSWnU2WdzT7sQugHSwGiIsKWe4O3");

        $manager->persist($apiToken);

        $manager->flush();
    }
}
