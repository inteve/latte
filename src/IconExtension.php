<?php

	declare(strict_types=1);

	namespace Inteve\Latte;

	use Phig\HtmlIcons;
	use Latte;


	class IconExtension extends Extension
	{
		/** @var HtmlIcons */
		private $icons;

		/** @var string */
		private $tagName;


		public function __construct(
			HtmlIcons $icons,
			string $tagName = 'icon'
		)
		{
			$this->icons = $icons;
			$this->tagName = $tagName;
		}


		public function getTags(): array
		{
			return [
				[$this, 'installTags'],
			];
		}


		public function installTags(Latte\Compiler $compiler): void
		{
			$me = new Latte\Macros\MacroSet($compiler);
			$me->addMacro($this->tagName, [$this, 'macroIcon']);
		}


		/**
		 * {icon "name"}
		 */
		public function macroIcon(Latte\MacroNode $node, Latte\PhpWriter $writer): string
		{
			// $node->validate(TRUE, [], FALSE);
			if ($node->args === '') {
				throw new \RuntimeException('Missing arguments in {icon} macro.');
			}

			if ($node->modifiers !== '') {
				throw new \RuntimeException('Filters are not allowed in {icon} macro.');
			}

			$iconName = $node->tokenizer->fetchWord();

			if ($iconName === NULL) {
				throw new \RuntimeException('Missing icon name.');
			}

			return '?>' . $this->icons->get($iconName) . '<?php';
		}
	}
