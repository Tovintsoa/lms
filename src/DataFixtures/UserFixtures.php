<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $res = $this->getData();
        foreach ($res as [ $email, $role, $mdp]) {
            $us = new User();
            $us->setEmail($email)->setRoles($role)->setPassword($this->passwordEncoder->encodePassword($us, $mdp));

            $manager->persist($us);
        }

        $manager->flush();
        $manager->flush();
    }
    private function getData()
    {
        return [
            ['monique@exempleLMS.com',  ['ROLE_ETUDIANT'], 'monique'],
            ['gerard@exempleLMS.com',  ['ROLE_ETUDIANT'], 'gerard'],
            ['admin@exempleLMS.com',  ['ROLE_PROFESSEUR'], 'admin'],
        ];
    }
}
