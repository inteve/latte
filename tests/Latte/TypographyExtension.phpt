<?php

declare(strict_types=1);

use Inteve\Latte\TypographyExtension;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test('default', function () {
	$latte = Tests::createLatte(new TypographyExtension);
	Tests::createTemplates($latte, [
		'main' => '{=\'My a text\'|typography}',
	]);
	Assert::same('My a&nbsp;text', $latte->renderToString('main'));
});
