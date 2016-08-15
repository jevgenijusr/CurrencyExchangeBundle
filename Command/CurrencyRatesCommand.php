<?php

namespace Jev\CurrencyExchangeBundle\Command;

use Jev\CurrencyExchangeBundle\Services\CurrencyRatesManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $providers = $this->currencyRatesManager->getProviders();

        foreach ($providers as $provider) {
            $output->writeln($provider->getRates());
        }
    }
}
