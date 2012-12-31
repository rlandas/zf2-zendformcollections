<?php

namespace Product\Entity;

use App\Entity\AbstractEntity;

class Product extends AbstractEntity
{
	public function getId()
	{
		return $this->product_id;
	}

	public function getBrand()
	{
		if ($brandId = $this->brand_id) {
			$brand = $this->brandEntity->getTable()->getByBrandId($brandId);
			if ($brand) {
				$this->setData('brand', $brand);
			}
		}

		return $this->_getData('brand');
	}

	protected $brandEntity;

	public function getBrandEntity ()
	{
		return $this->brandEntity;
	}

	public function setBrandEntity (Brand $brand)
	{
		$this->brandEntity = $brand;
		return $this;
	}

	public function getCategories ()
	{
		if ($categoryIds = $this->category_ids) {
			$categoryIds = explode(",", $categoryIds);
			$categories = $this->categoryEntity->getTable()->getAllByCategoryId($categoryIds);
			$this->setData('categories', $categories);
		}
		return $this->_getData('categories');
	}

	protected $categoryEntity;

	public function getCategoryEntity ()
	{
		return $this->categoryEntity;
	}

	public function setCategoryEntity (Category $category)
	{
		$this->categoryEntity = $category;
		return $this;
	}
}