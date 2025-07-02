<?php

	declare(strict_types=1);

	namespace Inteve\Latte;

	use Latte;
	use Nette;


	/**
	 * Latte extension for Nette DI.
	 */
	class DIExtension extends Nette\DI\CompilerExtension
	{
		public function beforeCompile()
		{
			$builder = $this->getContainerBuilder();
			$latteFactory = NULL;

			foreach ($builder->getDefinitions() as $definition) {
				if (!($definition instanceof Nette\DI\Definitions\ServiceDefinition)) {
					continue;
				}

				$factory = $definition->getFactory();

				if ($factory->entity === Latte\Engine::class) {
					$latteFactory = $definition;
					break;
				}
			}

			if ($latteFactory !== NULL) {
				$latteFactory->addSetup(ExtensionInstaller::class . '::install(?, ?)', [$latteFactory, $builder->findByType(Extension::class)]);
			}
		}
	}
