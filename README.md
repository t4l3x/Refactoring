# Refactoring
Simple (without DI,Factories, etc..) Refactored version of test.php . To begin, clone the repository, install dependencies using Composer, and run the PHPUnit tests.


```composer install```
 ```./vendor/bin/phpunit tests/ for test. ```

---
### explanation of refactored application structure
The structure consists of three main components: 
DTO, Helpers, and Providers. The DTO (Data Transfer Object) 
component is responsible for managing the data that is passed
between different parts of the application,
such as between the services and providers
. The Helpers component provides utility functions and tools
that can be used by other parts of the application.
The Providers component is responsible for 
getting data from external services, such as 
for retrieving exchange rates or BIN information, 
and for processing the responses. Finally, the Services 
component is where the main logic of the application is implemented,
using the other components as needed.

---
# Main task:
## Example `input.txt` file

```
{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
{"bin":"45417360","amount":"10000.00","currency":"JPY"}
{"bin":"41417360","amount":"130.00","currency":"USD"}
{"bin":"4745030","amount":"2000.00","currency":"GBP"}

```

## Running the code

Assuming PHP code is in `test.php`, you could run it by this command, output might be different due to dynamic data:
```
> php test.php input.txt
1
0.46180844185832
1.6574127786525
2.4014038976632
43.714413735069

```

# Notes about this code

1. Idea is to calculate commissions for already made transactions;
2. Transactions are provided each in it's own line in the input file, in JSON;
3. BIN number represents first digits of credit card number. They can be used to resolve country where the card was issued;
4. We apply different commission rates for EU-issued and non-EU-issued cards;
5. We calculate all commissions in EUR currency.

# Requirements for your code

1. It **must** have unit tests. If you haven't written any previously, please take the time to learn it before making the task, you'll thank us later.
    1. Unit tests must test the actual results and still pass even when the response from remote services change (this is quite normal, exchange rates change every day). This is best accomplished by using mocking.
1. As an improvement, add ceiling of commissions by cents. For example, `0.46180...` should become `0.47`.
1. It should give the same result as original code in case there are no failures, except for the additional ceiling.
1. Code should be extendible – we should not need to change existing, already tested functionality to accomplish the following:
    1. Switch our currency rates provider (different URL, different response format and structure, possibly some authentication);
    2. Switch our BIN provider (different URL, different response format and structure, possibly some authentication);
    3. Just to note – no need to implement anything additional. Just structure your code so that we could implement that later on without braking our tests;
1. It should look as you'd write it yourself in production – consistent, readable, structured. Anything we'll find in the code, we'll treat as if you'd write it yourself. Basically it's better to just look at the existing code and re-write it from scratch. For example, if `'yes'`/`'no'`, ugly parsing code or `die` statements are left in the solution, we'd treat it as an instant red flag.
1. Use composer to install testing framework and any needed dependencies you'd like to use, also for enabling autoloading.
1. Do not use Paysera name in titles, descriptions or the code itself. This helps others to find the libraries that are really related to our services and/or are developed and maintained by our team.
