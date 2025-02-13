<?php declare(strict_types = 1);

namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\IntegerType;
use PHPStan\Type\Type;
use function strtolower;

final class IteratorToArrayFunctionReturnTypeExtension implements DynamicFunctionReturnTypeExtension
{

	public function isFunctionSupported(FunctionReflection $functionReflection): bool
	{
		return strtolower($functionReflection->getName()) === 'iterator_to_array';
	}

	public function getTypeFromFunctionCall(FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope): Type
	{
		$arguments = $functionCall->getArgs();

		if ($arguments === []) {
			return ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
		}

		$traversableType = $scope->getType($arguments[0]->value);
		$arrayKeyType = $traversableType->getIterableKeyType();

		if (isset($arguments[1])) {
			$preserveKeysType = $scope->getType($arguments[1]->value);

			if ($preserveKeysType instanceof ConstantBooleanType && !$preserveKeysType->getValue()) {
				$arrayKeyType = new IntegerType();
			}
		}

		return new ArrayType(
			$arrayKeyType,
			$traversableType->getIterableValueType()
		);
	}

}
