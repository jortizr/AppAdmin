<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
use App\Factory\PostFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\UserFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'name' => 'admin',
            'email' => 'admin@app.com',
            'roles' => ['ROLE_ADMIN'],
        ]);
        UserFactory::createOne([
            'name' => 'User',
            'email' => 'user@app.com',
        ]);
        UserFactory::createMany(8);
        CategoryFactory::createMany(8);

        PostFactory::createMany(40, function (){
            return [
                'comments' => CommentFactory::new()->range(0,8),
                'category' => CategoryFactory::random(),
                'user' => UserFactory::random(),
            ];
        });
    }
}
