<?php

namespace Jev\CurrencyExchangeBundle\Command;

use Jev\CurrencyExchangeBundle\Services\CurrencyRatesManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

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
        
        foreach ($this->currencyRatesManager->getProviders() as $provider) {
            $rates = $provider->getRates();
            $output->writeln('');
            $output->writeln($baseCurrency . ' rates from '. $provider->getName());
            foreach ($rates as $currencyRate) {
                if($currencyRate['base'] != $baseCurrency) continue;
                foreach ($currencyRate['rates'] as $key => $rate) {
                    if($key != $foreignCurrency) continue;
                    $output->writeln($key .':'. $rate);
                }
            }
        }
        
    }
}