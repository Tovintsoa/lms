<?php
namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserManager
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserRepository|ObjectRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager,  UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(User::class);
        $this->passwordEncoder = $passwordEncoder;
    }

    public function create(User $user,$plainPassword = null,$role){
        $this->setPassword($user, $plainPassword);
        $user->setRoles([$role]);
    }
    /**
     * @param User $user
     */
    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
    /**
     * @param User $user
     * @param $plainPassword
     */
    public function setPassword(User $user, $plainPassword): void
    {
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $plainPassword
            )
        );
    }

}