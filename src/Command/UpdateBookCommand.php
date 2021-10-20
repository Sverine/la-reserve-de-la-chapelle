<?php

namespace App\Command;

use App\Repository\BookLoanRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateBookCommand extends Command
{

    //protected static $name = 'app:update-book';

    private $bookRepository;
    private $bookLoanRepository;
    private $entityManager;
    protected static $defaultName = 'app:update-book';

    public function __construct(BookRepository $bookRepository, BookLoanRepository $bookLoanRepository, EntityManagerInterface $entityManager)
    {
        $this->bookRepository = $bookRepository;
        $this->bookLoanRepository = $bookLoanRepository;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // If you don't like using the $defaultDescription static property,
            // you can also define the short description using this method:
            // ->setDescription('...')

            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to update a book every day if book has not been picked up after 3 days')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

        $loansReserved = $this->bookLoanRepository->findByDateReserved();

        $loansLateReserved= [];
        foreach($loansReserved as $loan){
            $diff = $loan->getDateReserved()->diff(new \DateTime('now'));
            if($diff->days >= 3 && !$loan->getDateLoan()){
                $loansLateReserved[]= $loan;
            }
        }

        if(!empty($loansLateReserved)){
            foreach($loansLateReserved as $loan){

                /*UPDATE BOOK*/
                $bookToUpdate = $loan->getBook();
                $bookToUpdate->setIsReserved(false);
                $this->entityManager->persist($bookToUpdate);

                /*REMOVE LOAN*/
                $this->entityManager->remove($loan);

                $this->entityManager->flush();

                $output->writeln(['Livre :'.$loan->getBook().' has been updated']);
            }
        }else{
            $output->writeln(['No book updated']);
        }

        return Command::SUCCESS;
    }


}