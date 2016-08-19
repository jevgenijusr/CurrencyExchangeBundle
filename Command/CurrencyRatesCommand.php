<?php

namespace Jev\CurrencyExchangeBundle\Command;

use Jev\CurrencyExchangeBundle\Services\CurrencyRatesManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class CurrencyRatesCommand extends ContainerAwareCommand
{
    private $currencyRatesManager;
    
    public function __construct(CurrencyRatesManager $currencyRatesManager)
    {
        $this->currencyRatesManager = $currencyRatesManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('currency:rates')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please select base currency',
            $this->currencyRatesManager->getBaseCurrencies(),
            0
        );
        $question->setErrorMessage('Currency %s is invalid.');
        $baseCurrency = $helper->ask($input, $output, $question);

        $question = new ChoiceQuestion(
            'Please select foreign currency',
            $this->currencyRatesManager->getForeignCurrencies(),
            0
        );
        $question->setErrorMessage('Currency %s is invalid.');
        $foreignCurrency = $helper->ask($input, $output, $question);

        $date = new \DateTime('now');
        
        foreach ($this->currencyRatesManager->getProviders() as $provider) {
            
            $rates = $this->currencyRatesManager->getRates($provider, $baseCurrency, $foreignCurrency, $date);
            
            $output->writeln('');
            $output->writeln($baseCurrency . ' rates from '. $provider->getName());
            $output->writeln($foreignCurrency .':'. $rates);
        }
    }
}
