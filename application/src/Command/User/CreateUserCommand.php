<?php

namespace App\Command\User;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

use App\Services\UserManager;
use App\Entity\User;

class CreateUserCommand extends Command {
    protected static $defaultName = 'app:user:create';

    private $userManager;
    private $user;

    public function __construct(UserManager $userManager) {
        $this->userManager = $userManager; 

        parent::__construct();
    }

    protected function configure() {
        $this->setName(self::$defaultName)
            ->setDescription('Creates a new user.')
            ->setDefinition(array(
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputArgument('roles', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Set the user roles (separate multiple names with a space)?'),
                new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the user as super admin'),
                new InputOption('update', null, InputOption::VALUE_NONE, 'Updates an existing user instead')
            ))
            ->setHelp(<<<'EOT'
The <info>app:user:create</info> command creates a user:
  <info>php %command.full_name% chicks@example.com mypassword</info>
You can create a user with roles with a comma delimited string
  <info>php %command.full_name% admin@example.com mypassword ROLE_USER,ROLE_ADMIN,ROLE_SUPER_ADMIN</info>
  You can create a super admin via the super-admin flag:
  <info>php %command.full_name% admin@example.com mypassword --super-admin</info>
EOT
            );
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output) {
        $questions = array();
        if (!$input->getArgument('email')) {
            $question = new Question('Please choose an email:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty');
                }
                return $email;
            });
            $questions['email'] = $question;
        }
        if (!$input->getArgument('password')) {
            $question = new Question('Please choose a password:');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password can not be empty');
                }
                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }
        if (!$input->getArgument('roles')) {
            $question = new Question('Please choose Roles:');
            $question->setValidator(function ($roles) {
                //TODO validate for valid roles
                return $roles;
            });
            $question->setHidden(true);
            $questions['roles'] = $question;
        }
        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
        
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        try {
            $this->user = new User();
            $this->user->setEmail($input->getArgument('email'))
                ->setPlainPassword($input->getArgument('password'))
                ->setIsEmailConfirmed(true)
                ;
            $roles = $input->getArgument('roles');
            $superadmin = $input->getOption('super-admin');

            if (!empty($roles) && is_string($roles)) {
                $this->user->setRoles(explode(' ', $roles));
            }
            if ($superadmin) {
                $this->user->addRole('ROLE_SUPER_ADMIN');
            }

            if ($input->getOption('update')) {
                $this->userManager->updateUser($this->user);
                $output->writeln('User updated');

            } else {
                $this->userManager->createUser($this->user);
                $output->writeln('User Created');
            }
        } catch(\Exception $ex) {
            $output->writeln($ex->getMessage());

            if ($input->getOption('update')) {
                $output->writeln('Failed to update user');
            } else {
                $output->writeln('Failed to create user');
            }
        }
    }
}