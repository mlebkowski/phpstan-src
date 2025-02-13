<?php

function foo()
{

	/** @var string|null $alwaysDefinedNullable */
	$alwaysDefinedNullable = doFoo();

	if (isset($alwaysDefinedNullable)) { // fine, checking for nullability

	}

	$alwaysDefinedNotNullable = 'string';
	if (isset($alwaysDefinedNotNullable)) { // always true

	}

	if (doFoo()) {
		$sometimesDefinedVariable = 1;
	}

	if (isset(
		$sometimesDefinedVariable, // fine, this is what's isset() is for
		$neverDefinedVariable // always false
	)) {

	}

	/** @var array|null $anotherAlwaysDefinedNullable */
	$anotherAlwaysDefinedNullable = doFoo();

	if (isset($anotherAlwaysDefinedNullable['test']['test'])) { // fine, checking for nullability

	}

	/** @var array $anotherAlwaysDefinedNotNullable */
	$anotherAlwaysDefinedNotNullable = doFoo();
	if (isset($anotherAlwaysDefinedNotNullable['test']['test'])) { // fine, variable always exists, but what about the array index?

	}

	if (isset($anotherNeverDefinedVariable['test']['test']->test['test']['test'])) { // always false

	}

	if (isset($yetAnotherNeverDefinedVariable::$test['test'])) { // always false

	}

	if (isset($_COOKIE['test'])) { // fine

	}

	if (something()) {

	} elseif (isset($yetYetAnotherNeverDefinedVariableInIsset)) { // always false

	}

	if (doFoo()) {
		$yetAnotherVariableThatSometimesExists = 1;
	}

	if (something()) {

	} elseif (isset($yetAnotherVariableThatSometimesExists)) { // fine

	}

	/** @var string|null $nullableVariableUsedInTernary */
	$nullableVariableUsedInTernary = doFoo();
	echo isset($nullableVariableUsedInTernary) ? 'foo' : 'bar'; // fine

	/** @var int|null $forVariableInit */
	$forVariableInit = doFoo();

	/** @var int|null $forVariableCond */
	$forVariableCond = doFoo();

	/** @var int|null $forVariableLoop */
	$forVariableLoop = doFoo();

	for ($i = 0, $init = isset($forVariableInit); $i < 10 && isset($forVariableCond); $i++, $loop = isset($forVariableLoop)) {

	}

	if (something()) {
		$variableInWhile = 1;
	}

	while (isset($variableInWhile)) {
		unset($variableInWhile);
	}

	if (something()) {
		$variableInDoWhile = 1;
	}

	do {
		$anotherVariableInDoWhile = 1;
		echo isset($yetAnotherVariableInDoWhile); // fine
	} while (
		isset($variableInDoWhile) // fine
		&& isset($anotherVariableInDoWhile) // always defined
		&& ($yetAnotherVariableInDoWhile = 1)
	);

	switch (true) {
		case $variableInFirstCase = true:
			isset($variableInSecondCase); // does not exist yet
		case $variableInSecondCase = true:
			isset($variableInFirstCase); // always defined
			$variableAssignedInSecondCase = true;
			break;
		case whatever():
			isset($variableInFirstCase); // always defined
			isset($variableInSecondCase); // always defined
			$variableInFallthroughCase = true;
			isset($variableAssignedInSecondCase); // surely undefined
		case foo():
			isset($variableInFallthroughCase); // fine
		default:

	}

	if (foo()) {
		$mightBeUndefinedForSwitchCondition = 1;
		$mightBeUndefinedForCaseNodeCondition = 1;
	}

	switch (isset($mightBeUndefinedForSwitchCondition)) { // fine
		case isset($mightBeUndefinedForCaseNodeCondition): // fine
			break;
	}

	$alwaysDefinedForSwitchCondition = 1;
	$alwaysDefinedForCaseNodeCondition = 1;

	switch (isset($alwaysDefinedForSwitchCondition)) {
		case isset($alwaysDefinedForCaseNodeCondition):
			break;
	}

}

function () {
	$alwaysDefinedNotNullable = 'string';
	if (doFoo()) {
		$sometimesDefinedVariable = 1;
	}

	if (isset(
		$alwaysDefinedNotNullable, // always true
		$sometimesDefinedVariable, // fine, this is what's isset() is for
		$neverDefinedVariable // always false
	)) {

	}
};

function () {
	try {
		if (something()) {
			throw new \Exception();
		}
		$test = 'fooo';
	} finally {
		if (isset($test)) {

		}
	}
};

function () {
	/** @var string[] $strings */
	$strings = doFoo();
	foreach ($strings as $string) {

	}

	if (isset($string)) {

	}
};

function () {
	/** @var mixed $bar */
	$bar = $this->get('bar');
	if (isset($bar)) {
		$bar = (int) $bar;
	}
	if (isset($bar)) {
		echo $bar;
	}
};

function () {
	while (true) {
		if (rand() === 1) {
			$a = 'a';
			continue;
		}

		if (!isset($a)) {
			continue;
		}

		unset($a);
	}
};

function () {
	($a = rand(0, 5)) && rand(0, 1);
	isset($a);
};


function () {
	rand(0, 1) && ($a = rand(0, 5));
	isset($a);
};

function () {
    $null = null;
    if (isset($null)) { // always false

    }
};

function () {
    isset($_SESSION);
    isset($_SESSION['foo']);
};
