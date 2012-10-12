<?php

namespace Product\Entity;

class Category
{

	/**
	 *
	 * @var string
	 */
	protected $name;

	/**
	 *
	 * @param string $name
	 * @return Category
	 */
	public function setName ($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function getName ()
	{
		return $this->name;
	}

	public function exchangeArray ()
	{
		return get_object_vars($this);
	}
}