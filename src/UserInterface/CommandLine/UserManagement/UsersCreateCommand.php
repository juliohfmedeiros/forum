<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\CommandLine\UserManagement;

use App\Application\CommandBus;
use App\Application\UserManagement\CreateUserCommand;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\User\Email;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


/**
 * UsersCreateCommand
 *
 * @package App\UserInterface\CommandLine\UserManagement
 */
final class UsersCreateCommand extends Command
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var SymfonyStyle
     */
    private $style;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var User\Password
     */
    private $password;

    /**
     * UsersCreateCommand constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    /**
     * @inheritdoc
     */
    public function configure()
    {
        $this
            ->setName('users:create')
            ->setHelp('Creates a new user')
            ->setDescription('Creates a new user')
            ->addArgument('name', InputArgument::REQUIRED, 'User full name')
            ->addArgument('email', InputArgument::REQUIRED, 'User e-mail address')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->style = new SymfonyStyle($input, $output);

        $this->userName = $input->getArgument('name');
        $this->email = new Email($input->getArgument('email'));
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->style->title('Add a new user');
        parent::interact($input, $output);
        $response = $this->style->askHidden('Please provided a password');
        $this->password =  new User\Password($response);
    }

    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var User $user */
        $user = $this->commandBus->handle(new CreateUserCommand($this->userName, $this->email, $this->password));

        $this->style->success("User {$user->name()} successfully created!");
        return 0;
    }
}
