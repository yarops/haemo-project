<?php
namespace App\Modules;

/**
 * Class InlineStyler
 */
class InlineStyler
{
	/**
	 * @var array
	 */
	public array $styles = [];

	/**
	 * @var string|null
	 */
	private string|null $selector = null;

	/**
	 * @var string
	 */
	private string $mediaRules = '';

	/**
	 * @param bool $condition
	 *
	 * @return string
	 */
	public function render(bool $condition = true) : string
	{
		// skip rules if block if selector not contain properties
		if (!$condition || empty($this->styles)) {
			return '';
		}

		if(!is_string($this->selector)){
			$this->selector = uniqid('php-styles-');
		}

		$array = [];
		foreach ($this->styles as $key => $value) {
			$array[$key] = $key . ': ' . $value;
		}

		$css = implode(';', $array);

		if($this->mediaRules){
			echo "@media ({$this->mediaRules}) {";
		}
		echo "{$this->selector}{";
		echo $css;
		echo '}';
		if($this->mediaRules) {
			echo '}';
		}

		$selector = $this->selector;
		$this->selector = null;

		return $selector;
	}

	/**
	 * @param string $rules
	 *
	 * @return object InlineStyler
	 */
	public function media(string $rules) : object
	{
		$this->mediaRules = $rules;

		return $this;
	}

	/**
	 * @param string $key
	 * @param string|int $value
	 * @param string $unit
	 * @param bool $condition
	 *
	 * @return object $this
	 */
	public function set( string $key, string|int $value, string $unit = '', bool $condition = true) : object
	{
		if ($condition && !empty($value)) {
			$this->styles[$key] = $value . $unit;
		}
		return $this;
	}

	/**
	 * @param string $value
	 *
	 * @return object $this
	 */
	public function name(string $value) : object
	{
		$this->selector = $value;

		return $this;
	}
}