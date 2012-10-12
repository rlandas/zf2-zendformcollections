<?php

namespace Product\Entity;

class Brand implements
		EntityInterface
{

	/**
	 *
	 * @var int
	 */
	protected $brand_id;

	/**
	 *
	 * @var string
	 */
	protected $name;

	/**
	 *
	 * @var string
	 */
	protected $url;

	public function getId ()
	{
		return $this->getBrandId();
	}

	public function setId ($brandId)
	{
		return $this->setBrandId($brandId);
	}

	/**
	 *
	 * @return the $brand_id
	 */
	public function getBrandId ()
	{
		return $this->brand_id;
	}

	/**
	 *
	 * @param field_type $brand_id
	 */
	public function setBrandId ($brand_id)
	{
		$this->brand_id = $brand_id;
	}

	/**
	 *
	 * @param string $name
	 * @return Brand
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

	/**
	 *
	 * @param string $url
	 * @return Brand
	 */
	public function setUrl ($url)
	{
		$this->url = $url;
		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function getUrl ()
	{
		return $this->url;
	}

	public function exchangeArray ()
	{
		return get_object_vars($this);
	}

	public function toArray ()
	{
		return get_object_vars($this);
	}

	public function populate (array $rowData)
	{
		foreach ($rowData as $key => $value) {
			if (isset($this->$key))
				$this->$key = $value;
		}
	}
}