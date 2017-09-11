contentfleet
============

A Symfony project created on September 10, 2017, 1:40 pm.

**Observations and notes on decisions and trade-offs**:

- Configured to use SQLite DB, so no need to configure your database (only need to have PDO installed).
- Installation and testing:
```bash
  $ composer install # accept all defaults
  $ php bin/console doctrine:schema:update --force
  $ php bin/console doctrine:migrations:migrate
  $ phpunit tests/AppBundle
```
- Try in browser:
```bash
  $ php bin/console server:start
  # Open http://127.0.0.1:8000 in web browser
```
- Book DB has 9 books, not 10 as stated in the problem layout.
- Application behaviour dependent on user role (not explicitly required in problem layout but done anyway).
- Data from migration used instead of fixtures for automated tests.
- Testing only availability (basic functional test).
