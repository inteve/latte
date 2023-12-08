<?php

	declare(strict_types=1);

	namespace Inteve\Latte;


	abstract class Extension
	{
		/**
		 * @return array<callable(\Latte\Compiler):void>
		 */
		public function getTags(): array
		{
			return [];
		}


		/**
		 * @return array<string, callable>
		 */
		public function getFilters(): array
		{
			return [];
		}


		/**
		 * @return array<string, mixed>
		 */
		public function getProviders(): array
		{
			return [];
		}
	}
