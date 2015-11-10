PHPUnit Exercise
Solution:

    "src/User.php" contains refactored code from "legacyCode.php".

    "tests/UserTest.php" contains all the tests from "TechnicalTest.php"
    refactored for "User.php" class

    Do not need to load src/User.php in UserTest.php test-case. Composer
    uses autoloading to load User class.

Requirements:

	You'll need a computer with php (5.3.3 or greater) installed.

	Composer: Use https://getcomposer.org to install composer.

	You can use any editor/IDE you want and any operating system.

	There's no time limit.

	If you're not familiar with phpunit test mocks, check their
	website: https://phpunit.de/manual/current/en/test-doubles.html

	The source code is in the folder src/ and unit tests (phpunit)
	are in tests/

Before you start:

	from your console, in the root folder, run:

	    composer install

	to install phpunit

What's expected:

	- Some tests are failing, find what's wrong and fix it
	- Refactor the existing procedural code into object oriented code
	- You'll need to refactor the tests too to match the new code
	- Make sure the tests pass

How to run the tests:

	from your console, in the root folder, run:

	    vendor/bin/phpunit tests

Extra points:

	- Make it clean and readable, add comments
	- Feel free to add improvements to the code / tests
	- Extra points for following SOLID principles

