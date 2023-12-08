<?php

	declare(strict_types=1);

	namespace Inteve\Latte;

	use Latte;
	use Nette\Utils\Strings;


	class TypographyExtension extends Extension
	{
		const CHAR = 'A-Za-z\x{C0}-\x{2FF}\x{370}-\x{1EFF}';


		public function getFilters(): array
		{
			return [
				'typography' => function (Latte\Runtime\FilterInfo $info, $value) {
					if (!in_array($info->contentType, [NULL, Latte\Engine::CONTENT_TEXT])) {
						throw new \RuntimeException("Filter |typography used in incompatible content type {$info->contentType}.");
					}

					$info->contentType = Latte\Engine::CONTENT_HTML;
					$res = Strings::replace(
						Latte\Runtime\Filters::escapeHtml($value),
						'#(?<=^|[^0-9' . self::CHAR . '])([\x17-\x1F]*[ksvzouiaKSVZOUIA][\x17-\x1F]*)\s++(?=[\x17-\x1F]*[0-9' . self::CHAR . '])#mus',
						"\$1&nbsp;"
					);

					return $res;
				}
			];
		}
	}
