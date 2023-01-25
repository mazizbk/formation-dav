<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();



        for ($c = 0; $c < 3; $c++) {
            $category = new Category;
            $category->setName($faker->name);
            $category->setDescription('');
            $manager->persist($category);
            for ($p = 0; $p < mt_rand(15, 20); $p++) {
                $product = new Product;
                $product->setName($faker->name)
                    ->setPrice(rand(40, 3000))
                    ->setCategory($category)
                    ->setDescription('')
                    ->setStock(rand(3, 10))
                    ->setImage('https://dummyimage.com/404x400/fff/aaa');


                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
