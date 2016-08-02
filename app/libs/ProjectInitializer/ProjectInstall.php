<?php

namespace Console;

use Doctrine;
use Entity;
use Libs\ProjectInitializer;
use Model\Analytics;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectInstall extends Command {

    /** @var \Kdyby\Doctrine\EntityManager @inject */
    public $em;

    /** @var ProjectInitializer @inject */
    public $project_initializer;

    protected function configure() {
        $this->setName('project:install')->setDescription('Clean install - adds essential data to DB.');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        try {
            $this->project_initializer->initialize();

            $output->writeLn('<info>[OK] - PROJECT:INSTALL</info>');
            return 0; // zero return code means everything is ok
        } catch (\Exception $exc) {
            $output->writeLn('<error>PROJECT:INSTALL - ' . $exc->getMessage() . '</error>');
            return 1; // non-zero return code means error
        }
    }

}