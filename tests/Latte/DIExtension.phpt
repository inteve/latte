<?php

declare(strict_types=1);

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class TestExtension extends \Inteve\Latte\Extension
{
	public function getFilters(): array
	{
		return [
			'myReverse' => function ($s) { return strrev($s); },
		];
	}


	public function getTags(): array
	{
		return [
			function (\Latte\Compiler $compiler) {
				$me = new Latte\Macros\MacroSet($compiler);
				$me->addMacro('myTag', 'echo $this->global->myProvider;');
			}
		];
	}


	public function getProviders(): array
	{
		return [
			'myProvider' => 'test',
		];
	}
}


test('default', function () {
	$loader = new Nette\DI\ContainerLoader(Tests::createTempDirectory());
	$class = $loader->load(function (\Nette\DI\Compiler $compiler) {
		$compiler->addExtension('extensions', new \Nette\DI\Extensions\ExtensionsExtension);
		$compiler->loadConfig(__DIR__ . '/fixtures/DIExtension.neon');
	});
	$container = new $class;
	assert($container instanceof \Nette\DI\Container);
	$latte = $container->getByType(\Latte\Engine::class);
	assert($latte instanceof \Latte\Engine);
	Tests::createTemplates($latte, [
		'main' => '{myTag}:{=\'mytext\'|myReverse}'
	]);

	Assert::same('test:txetym', $latte->renderToString('main'));
});
