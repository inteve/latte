<?php

declare(strict_types=1);

use Inteve\Latte\IconExtension;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class Icon implements \Phig\HtmlString
{
	/** @var string */
	private $html;


	public function __construct(string $html)
	{
		$this->html = $html;
	}


	public function __toString()
	{
		return $this->html;
	}
}


class AppIcons implements \Phig\HtmlIcons
{
	function get($icon)
	{
		return new Icon('<img src="/path/to/' . $icon . '.svg">');
	}
}


test('default', function () {
	$latte = Tests::createLatte(new IconExtension(new AppIcons));
	Tests::createTemplates($latte, [
		'main' => '{icon test}',
		'multiple' => '{icon test}{icon bar}{icon foo}',
	]);
	Assert::same('<img src="/path/to/test.svg">', $latte->renderToString('main'));
	Assert::same('<img src="/path/to/test.svg"><img src="/path/to/bar.svg"><img src="/path/to/foo.svg">', $latte->renderToString('multiple'));
});


test('Missing name', function () {
	$latte = Tests::createLatte(new IconExtension(new AppIcons));
	Tests::createTemplates($latte, [
		'main' => '{icon}',
	]);

	Assert::exception(function () use ($latte) {
		$latte->renderToString('main');
	}, \Latte\CompileException::class);
});


test('No filters', function () {
	$latte = Tests::createLatte(new IconExtension(new AppIcons));
	Tests::createTemplates($latte, [
		'main' => '{icon asdf|filter}',
	]);

	Assert::exception(function () use ($latte) {
		$latte->renderToString('main');
	}, \Latte\CompileException::class);
});
