<?php

namespace App\Command;

use App\Entity\Reading;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// run with: 'php bin/console app:create-reading crianza 'Faustino V' tinto 17.0 5.0 6.2
// run with: 'php bin/console app:create-reading verdejo 'Faustino V' blanco 17.0 5.0 6.2 'Observaciones aqui.'
#[AsCommand(
    name: 'app:create-reading',
    description: 'Create a reading'
)]
class CreateReadingCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('variety', InputArgument::REQUIRED)
            ->addArgument('type', InputArgument::REQUIRED)
            ->addArgument('color', InputArgument::REQUIRED)
            ->addArgument('temperature', InputArgument::REQUIRED)
            ->addArgument('graduation', InputArgument::REQUIRED)
            ->addArgument('ph', InputArgument::REQUIRED)
            ->addArgument('observations', InputArgument::OPTIONAL);
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Creating reading.',
            '=================',
            '',
        ]);

        $reading = new Reading();
        $today = new \DateTime();
        $reading->setYear($today->format('Y'));
        $reading->setVariety($input->getArgument('variety'));
        $reading->setType($input->getArgument('type'));
        $reading->setColor($input->getArgument('color'));
        $reading->setTemperature($input->getArgument('temperature'));
        $reading->setGraduation($input->getArgument('graduation'));
        $reading->setPh($input->getArgument('ph'));

        $observations = $input->getArgument('observations');
        if (!is_null($observations)) $reading->setObservations($observations);

        $this->entityManager->persist($reading);
        $this->entityManager->flush();

        $output->writeln('Done.');
        return Command::SUCCESS;
    }
}