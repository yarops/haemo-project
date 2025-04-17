<?php
namespace App\Modules\InlineStyler;

/**
 * Class InlineStyler
 */
class MediaQueries
{
	private string $name = '';

	/**
	 * @var array|null
	 */
	private array|null $selectors = null;

	/**
	 * @var string
	 */
	private string $mediaRule = '';

	public function __call($methodName, $arguments) {
		if (! property_exists($this, $methodName)) {
			throw new \Exception("Bad Method Name Exception: $methodName");
		}

		return $this->$methodName;
	}

	/**
	 * @param string $slug
	 * @param string $rule
	 *
	 * @return object InlineStyler
	 */
	public function setMedia(string $slug, string $rule) : object
	{
		$this->mediaRule = $rule;

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
}