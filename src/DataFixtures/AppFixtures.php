<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{


    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {

        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadTasks($manager);
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadTasks(ObjectManager $manager)
    {
        $tasks = [
            ['Aprender masatu', 'sgomez'],
            ['Leer SIF', 'p42argea'],
            ['Ganar un fornite', 'p42argea'],
            ['Abrir cofre de eleccion', 'sgomez'],
        ];

        foreach ($tasks as $task) {
            $entity = new Task();
            $entity->setDescription($task[0]);
            $user = $this->getReference($task[1]);
            $entity->setOwner($user);

            $manager->persist($entity);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {
        $users = [
            'sgomez',
            'p42argea',
        ];

        foreach ($users as $user)
        {
            $entity = new User();
            $entity->setUsername($user);
            $password = $this->encoder->encodePassword($entity, 'secret');
            $entity->setPassword($password);

            $manager->persist($entity);
            $this->addReference($user, $entity);
        }

        $manager->flush();
    }
}
