<?php

namespace Jev\CurrencyExchangeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JevCurrencyExchangeBundle:Default:index.html.twig');
    }
}
