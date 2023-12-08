<?php

	declare(strict_types=1);

	namespace Inteve\Latte;


	class ExtensionInstaller
	{
		private function __construct()
		{
		}


		/**
		 * @param  Extension[] $extensions
		 */
		public static function install(\Latte\Engine $engine, array $extensions): void
		{
			foreach ($extensions as $extension) {
				foreach ($extension->getFilters() as $name => $callback) {
					$engine->addFilter($name, $callback);
				}

				foreach ($extension->getProviders() as $name => $provider) {
					$engine->addProvider($name, $provider);
				}
			}

			$engine->onCompile[] = function (\Latte\Engine $latte) use ($extensions) {
				$compiler = $latte->getCompiler();

				foreach ($extensions as $extension) {
					foreach ($extension->getTags() as $callback) {
						call_user_func($callback, $compiler);
					}
				}
			};
		}
	}
