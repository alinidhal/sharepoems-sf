<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    private function encode($user, $plaintextpassword)
    {
        return $this->passwordEncoder->encodePassword(
            $user,
            $plaintextpassword
        );
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $simpleUser = new User();
            $simpleUser->setNickname($faker->firstName());
            $simpleUser->setPassword($this->encode($simpleUser, "toto"));
            $simpleUser->setRoles(["USER_ROLE"]);
            $manager->persist($simpleUser);

            for ($j = 0; $j < mt_rand(0, 10); $j++) {
                $onePost = new Post();
                $onePost->setTitle($faker->word());
                $onePost->setDatetime($faker->dateTime("now", null));
                $onePost->setDescription($faker->text(255));
                $onePost->setImage("https://cdn.pixabay.com/photo/2021/06/04/06/09/cherries-6308871_960_720.jpg");
                $manager->persist($onePost);
            }
        }

        $manager->flush();
    }
}
