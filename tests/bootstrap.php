<?php

declare(strict_types=1);

use Inteve\Latte\Extension;
use Inteve\Latte\ExtensionInstaller;

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function test(string $description, Closure $closure): void
{
	$closure();
}


class Tests
{
	private function __construct()
	{
	}


	public static function createLatte(?Extension $extension = NULL): \Latte\Engine
	{
		$latte = new \Latte\Engine;

		if ($extension !== NULL) {
			ExtensionInstaller::install($latte, [$extension]);
		}

		return $latte;
	}


	/**
	 * @param  array<string, string> $templates
	 */
	public static function createTemplates(\Latte\Engine $latte, array $templates): void
	{
		$latte->setLoader(new \Latte\Loaders\StringLoader($templates));
	}


	public static function createTempDirectory(): string
	{
		@mkdir(__DIR__ . '/temp');  # @ - adresář již může existovat

		$tempDirectory = __DIR__ . '/temp/' . getmypid();
		Tester\Helpers::purge($tempDirectory);
		return $tempDirectory;
	}
}
