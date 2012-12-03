<?php

namespace Serge\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Serge\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setPassword($this->encodePassword($user, 'user'));
        $user->setEmail('user@user.com');
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->encodePassword($admin, 'admin'));
        $admin->setEmail('admin@admin.com');
        $manager->persist($admin);

        $manager->flush();
    }

    public function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}