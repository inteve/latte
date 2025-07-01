# Inteve\Latte

[![Build Status](https://github.com/inteve/latte/workflows/Build/badge.svg)](https://github.com/inteve/latte/actions)
[![Downloads this Month](https://img.shields.io/packagist/dm/inteve/latte.svg)](https://packagist.org/packages/inteve/latte)
[![Latest Stable Version](https://poser.pugx.org/inteve/latte/v/stable)](https://github.com/inteve/latte/releases)
[![License](https://img.shields.io/badge/license-New%20BSD-blue.svg)](https://github.com/inteve/latte/blob/master/license.md)

Extensions for Latte templates

<a href="https://www.janpecha.cz/donate/"><img src="https://buymecoffee.intm.org/img/donate-banner.v1.svg" alt="Donate" height="100"></a>


## Installation

[Download a latest package](https://github.com/inteve/latte/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/latte
```

Inteve\Latte requires PHP 8.0 or later and Latte 2.


## Usage

### Installation of extensions

``` php
\Inteve\Latte\ExtensionInstaller::install($latte, [
	new FooExtension,
	new BarExtension,
]);
```

or via Nette DI extension:

```neon
extensions:
	inteve.latte: Inteve\Latte\DIExtension

services:
	- FooExtension
	- BarExtension
```


### IconExtension

Creates new Latte tag `{icon foo}`. Saves icon code directly to compiled template. Requires implementation PHIG's `HtmlIcons` interface.

```php
\Inteve\Latte\ExtensionInstaller::install($latte, [
	new \Inteve\Latte\IconExtension($phigIcons),
]);
```

```latte
{icon myIcon}
```


### TypographyExtension

Creates new Latte filter `|typography`.

```php
\Inteve\Latte\ExtensionInstaller::install($latte, [
	new \Inteve\Latte\TypographyExtension,
]);
```

```latte
{='My a text'|typography} {* prints 'My a&nbsp;text' *}
```


### Custom extension

Just extends `Inteve\Latte\Extension`:

```php
class MyExtension extends \Inteve\Latte\Extension
{
	/**
	 * @return array<callable(\Latte\Compiler):void>
	 */
	public function getTags(): array
	{
		return [
			function (\Latte\Compiler $compiler) {
				$me = new Latte\Macros\MacroSet($compiler);
				$me->addMacro('myTag', ['MyLatteMacros', 'macroMyTag']);
			},
		];
	}


	/**
	 * @return array<string, callable>
	 */
	public function getFilters(): array
	{
		return [
			'myFilter' => function ($value) {
				return $value,
			},
		];
	}


	/**
	 * @return array<string, mixed>
	 */
	public function getProviders(): array
	{
		return [
			'myProvider' => 'foo bar',
		];
	}
}
```

------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
