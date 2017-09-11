contentfleet
============

A Symfony project created on September 10, 2017, 1:40 pm.

Observations and notes on decisions and trade-offs:

* Book DB has 9 books, not 10 as stated in the problem layout.
* Application behaviour dependent on user role (not explicitly required in problem layout).
* Data from migration used instead of fixtures for automated tests.
* Testing only availability (functional test).
