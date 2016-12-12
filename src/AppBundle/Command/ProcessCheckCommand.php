<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 28.11.16
 * Time: 17:08
 */

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use AppBundle\Controller\ProcessController;
use Symfony\Component\HttpFoundation\Request;

class ProcessCheckCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:process-check')

            // the short description shown while running "php bin/console list"
            ->setDescription('Checks if process need to be running.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to check presses for running...");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $request = Request::createFromGlobals();
        $controller = new ProcessController();

        $controller->setContainer($this->getContainer()); // from the ContainerAwareCommand interface
        $controller->checkAction($request);
    }
}