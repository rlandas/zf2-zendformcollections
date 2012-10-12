<?php

namespace Product\Entity;

class Product implements
		EntityInterface
{

	protected $product_id;

	/**
	 *
	 * @var string
	 */
	protected $name;

	/**
	 *
	 * @var int
	 */
	protected $price;

	/**
	 *
	 * @var int
	 */
	protected $brand_id;

	/**
	 *
	 * @var Brand
	 */
	protected $brand;

	/**
	 *
	 * @var array
	 */
	protected $categories;

	public function getId ()
	{
		return $this->getProductId();
	}

	public function setId ($productId)
	{
		return $this->setProductId($productId);
	}

	/**
	 *
	 * @return the $product_id
	 */
	public function getProductId ()
	{
		return $this->product_id;
	}

	/**
	 *
	 * @param field_type $product_id
	 */
	public function setProductId ($productId)
	{
		$this->product_id = $productId;
		return $this;
	}

	/**
	 *
	 * @param string $name
	 * @return Product
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
	 * @param int $price
	 * @return Product
	 */
	public function setPrice ($price)
	{
		$this->price = $price;
		return $this;
	}

	/**
	 *
	 * @return int
	 */
	public function getPrice ()
	{
		return $this->price;
	}

	/**
	 *
	 * @return the $brandId
	 */
	public function getBrandId ()
	{
		return $this->brand_id;
	}

	/**
	 *
	 * @param field_type $brandId
	 */
	public function setBrandId ($brandId)
	{
		$this->brand_id = $brandId;
		return $this;
	}

	/**
	 *
	 * @param Brand $brand
	 * @return Product
	 */
	public function setBrand (Brand $brand)
	{
		$this->brand = $brand;
		return $this;
	}

	/**
	 *
	 * @return Brand
	 */
	public function getBrand ()
	{
		return $this->brand;
	}

	/**
	 *
	 * @param array $categories
	 * @return Product
	 */
	public function setCategories (array $categories)
	{
		$this->categories = $categories;
		return $this;
	}

	/**
	 *
	 * @return array
	 */
	public function getCategories ()
	{
		return $this->categories;
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