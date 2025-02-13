<?php declare(strict_types = 1);

namespace PHPStan\Rules\Methods;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends \PHPStan\Testing\RuleTestCase<IncompatibleDefaultParameterTypeRule>
 */
class IncompatibleDefaultParameterTypeRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new IncompatibleDefaultParameterTypeRule();
	}

	public function testMethods(): void
	{
		$this->analyse([__DIR__ . '/data/incompatible-default-parameter-type-methods.php'], [
			[
				'Default value of the parameter #6 $resource (false) of method IncompatibleDefaultParameter\Foo::baz() is incompatible with type resource.',
				45,
			],
			[
				'Default value of the parameter #6 $resource (false) of method IncompatibleDefaultParameter\Foo::bar() is incompatible with type resource.',
				55,
			],
		]);
	}

	public function testTraitCrash(): void
	{
		$this->analyse([__DIR__ . '/data/incompatible-default-parameter-type-trait-crash.php'], []);
	}

	public function testBug4011(): void
	{
		$this->analyse([__DIR__ . '/data/bug-4011.php'], []);
	}

	public function testBug2573(): void
	{
		$this->analyse([__DIR__ . '/data/bug-2573.php'], []);
	}

	public function testNewInInitializers(): void
	{
		if (PHP_VERSION_ID < 80100 && !self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires PHP 8.0.');
		}

		$this->analyse([__DIR__ . '/data/new-in-initializers.php'], [
			[
				'Default value of the parameter #1 $i (stdClass) of method MethodNewInInitializers\Foo::doFoo() is incompatible with type int.',
				11,
			],
		]);
	}

	public function testDefaultValueForPromotedProperty(): void
	{
		if (!self::$useStaticReflectionProvider) {
			$this->markTestSkipped('Test requires static reflection.');
		}

		$this->analyse([__DIR__ . '/data/default-value-for-promoted-property.php'], [
			[
				'Default value of the parameter #1 $foo (string) of method DefaultValueForPromotedProperty\Foo::__construct() is incompatible with type int.',
				9,
			],
			[
				'Default value of the parameter #2 $foo (string) of method DefaultValueForPromotedProperty\Foo::__construct() is incompatible with type int.',
				10,
			],
		]);
	}

}
