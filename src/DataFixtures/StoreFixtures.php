<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StoreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Permet l'utilisation de Faker.
        $faker = \Faker\Factory::create("fr_FR");

        // Génération de catégories.
        for ($c=0; $c<4; $c++){
            $category = new Category();
            $category->setName($faker->word())
                     ->setDescription($faker->sentence(5));

            $manager->persist($category);

            // Génération de produits
            // Entre 1 et 5 produits par catégories.
            for ($i=0; $i<mt_rand(1, 4); $i++){
                $product = new Product();
                $product->setName($faker->word());
                $product->setDescription($faker->sentence(3));
                $product->setPrice($faker->randomFloat(2, 1, 500));
                $product->setCategory($category);
                
                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
