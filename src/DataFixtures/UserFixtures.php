<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
 public function __construct(UserPasswordEncoderInterface $encoder)
{
    $this->encoder = $encoder;
}
private $encoder;

    public function load(ObjectManager $manager)
    {
        
   $user = new User();
    $user->setRoles(['ROLES_USER', 'ROLES_ADMIN']);
    $user->setFirstname('John');
    $user->setLastname('Doe');
    $user->setEmail('john@doe.com');
    $password = $this->encoder->encodePassword($user, 'admin');
    $user->setPassword($password);

    $manager->persist($user);
    
            for ($i = 0; $i < 5; $i++) {
   $users = new User();
    $users->setRoles(['ROLES_USER']);
    $users->setFirstname('John'.$i);
    $users->setLastname('Doe');
    $users->setEmail('john'. $i .'@doe.com');
    $password = $this->encoder->encodePassword($users, 'user'. $i);
    $users->setPassword($password);

    $manager->persist($users);
        }
        $manager->flush();
    }
}
