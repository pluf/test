# Pluf Test

[![Build Status](https://travis-ci.com/pluf/test.svg?branch=master)](https://travis-ci.com/pluf/test)
[![codecov](https://codecov.io/gh/pluf/test/branch/master/graph/badge.svg)](https://codecov.io/gh/pluf/test)
[![Maintainability](https://api.codeclimate.com/v1/badges/513f356bdf26065cc009/maintainability)](https://codeclimate.com/github/pluf/test/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/513f356bdf26065cc009/test_coverage)](https://codeclimate.com/github/pluf/test/test_coverage)
[![Coverage Status](https://coveralls.io/repos/github/pluf/test/badge.svg?branch=master)](https://coveralls.io/github/pluf/test?branch=master)

This tutorial assumes that you use PHP 7.3 or PHP 7.4. You will learn how to write simple unit tests as well as how to download and run PlufTest.

PlufTest is based on PHPUnit 8.

## Install

You can add Pluf/Test as a local, per-project, development-time dependency to your project using Composer:

	➜ composer require --dev pluf/test ^6
	
	➜ ./vendor/bin/pluftest --version
	Pluf/Test 6.0.0 by pluf.ir and contributors.


The example shown above assumes that composer is on your $PATH.

Your composer.json should look similar to this:

	{
	    "autoload": {
	        "classmap": [
	            "src/"
	        ]
	    },
	    "require-dev": {
	        "pluf/test": "^9"
	    }
	}

## Test Code

suppose there is a code 

	src/Email.php

with content:

	<?php
	declare(strict_types=1);
	
	final class Email
	{
	    private $email;
	
	    private function __construct(string $email)
	    {
	        $this->ensureIsValidEmail($email);
	
	        $this->email = $email;
	    }
	
	    public static function fromString(string $email): self
	    {
	        return new self($email);
	    }
	
	    public function __toString(): string
	    {
	        return $this->email;
	    }
	
	    private function ensureIsValidEmail(string $email): void
	    {
	        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	            throw new InvalidArgumentException(
	                sprintf(
	                    '"%s" is not a valid email address',
	                    $email
	                )
	            );
	        }
	    }
	}

Create a file:

	tests/EmailTest.php

And create the test class

	<?php
	declare(strict_types=1);
	
	use PHPUnit\Framework\TestCase;
	
	final class EmailTest extends TestCase
	{
	    public function testCanBeCreatedFromValidEmailAddress(): void
	    {
	        $this->assertInstanceOf(
	            Email::class,
	            Email::fromString('user@example.com')
	        );
	    }
	
	    public function testCannotBeCreatedFromInvalidEmailAddress(): void
	    {
	        $this->expectException(InvalidArgumentException::class);
	
	        Email::fromString('invalid');
	    }
	
	    public function testCanBeUsedAsString(): void
	    {
	        $this->assertEquals(
	            'user@example.com',
	            Email::fromString('user@example.com')
	        );
	    }
	}
	
The test is ready

Note: Do not put tests in a namespace.


## Run the test

	./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/EmailTest
	PHPUnit 8.0.0 by Sebastian Bergmann and contributors.
	
	...                                                                 3 / 3 (100%)
	
	Time: 70 ms, Memory: 10.00MB
	
	OK (3 tests, 3 assertions)



--bootstrap vendor/autoload.php instructs the PHPUnit command-line test runner to include vendor/autoload.php before the tests are run.

tests/EmailTest instructs the PHPUnit command-line test runner to execute the tests of the EmailTest class that is declared in tests/EmailTest.php.

Using tests instead of tests/EmailTest would instruct the PHPUnit command-line test runner to execute all tests found declared in *Test.php sourcecode files in the tests directory.


## Contributing

If you would like to contribute to Pluf, please read the README and CONTRIBUTING documents.

The most important guidelines are described as follows:

>All code contributions - including those of people having commit access - must go through a pull request and approved by a core developer before being merged. This is to ensure proper review of all the code.

Fork the project, create a feature branch, and send us a pull request.

To ensure a consistent code base, you should make sure the code follows the PSR-2 Coding Standards.
