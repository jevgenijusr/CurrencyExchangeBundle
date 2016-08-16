CurrencyExchangeBundle
===

Query different banks for specific currency pair exchange rate. Determine which bank provides best exchange rate.

Installation
---
    
### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the following
command to download the latest stable version of this bundle:

```bash
$ composer require jevgenijus/currency-exchange-bundle
```

### Step 2: Enable the Bundle

Register bundles in `app/AppKernel.php`:

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            // ...
            new Jev\CurrencyExchangeBundle\JevCurrencyExchangeBundle(),   
        ];
    }

    // ...
}
```
       

### Step 3: Configure the Bundle

Configure the currencies you need in `config.yml` file.

```yml
# app/config/config.yml
jev_currency_exchange:
    base_currencies: ["EUR", "GBP"]
    foreign_currencies: ["AUD", "BGN", "CAD", "CHF"]
```

Usage
---

Command **currency:rates** which shows a table of exchange rates for a given 
currency pair.

```bash
$ app/console currency:rates
```

Command **currency:rate:best** gives the best exchange rate for a given 
currency pair. 

```bash
$ app/console currency:rate:best
```

License
---

This package is licensed under the MIT license. For the full copyright and
license information, please view the [LICENSE][1] file that was distributed
with this source code. 

[1]: LICENSE

