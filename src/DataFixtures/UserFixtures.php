<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setUsername('marcaosi');
        $user->setPassword('$argon2i$v=19$m=1024,t=2,p=2$ZHJPTlppdkhiSTZ0bU9XUQ$L6goSlIxhN8jyy9ORHgL/EhdGsiMm+/isi4xNAQtIBc');

        $manager->persist($user);

        $manager->flush();
    }
}
