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

            $nbPostsToCreate = random_int(0, 10);
            for ($j = 0; $j < $nbPostsToCreate; $j++) {
                $onePost = new Post();
                $onePost->setTitle($faker->word());
                $onePost->setDatetime($faker->dateTime("now", null));
                $onePost->setDescription($faker->text(255));
                $onePost->setImage($faker->imageUrl(640, 480, null, true, null, true));
                $manager->persist($onePost);
            }

            $manager->flush();
        }
    }
}
