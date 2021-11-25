<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Usuario;

class SetupAdminCommand extends Command
{
    const DEFAULT_USERNAME = "admin";
    const DEFAULT_PASSWORD = "admin";
    const ROLE_ADMIN = "ROLE_ADMIN";

    protected static $defaultName = 'app:setup:admin';
    protected static $defaultDescription = 'Add a user with the admin role.';

    private $passwordEncoder;
    private $em;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('username', InputArgument::OPTIONAL, 'Admin username', static::DEFAULT_USERNAME)
            ->addArgument('password', InputArgument::OPTIONAL, 'Admin password', static::DEFAULT_PASSWORD)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $role = self::ROLE_ADMIN;

        $user = new Usuario();
        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setRol(self::ROLE_ADMIN);

        $this->em->persist($user);
        $this->em->flush();

        $io->success("User \"$username\" has been created with the role \"$role\" and the password \"$password\".");

        return 0;
    }
}
