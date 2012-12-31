<?php

namespace Product;

use Product\Entity\Brand as BrandEntity;
use Product\Entity\Product as ProductEntity;
use Product\Entity\Category as CategoryEntity;
use Product\Table\BrandTable;
use Product\Table\ProductTable;
use Product\Table\CategoryTable;

class Module
{

	public function getAutoloaderConfig ()
	{
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php'
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
				)
			)
		);
	}

	public function getConfig ()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getServiceConfig ()
	{
		return array(
			'factories' => array(
				'Product\Entity\Brand' => function  ($sm)
				{
					$brand = new BrandEntity();
					$brand->setTable(new BrandTable($sm->get('Zend\Db\Adapter\Adapter')));
					return $brand;
				},
				'Product\Entity\Category' => function  ($sm)
				{
					$category = new CategoryEntity();
					$category->setTable(new CategoryTable($sm->get('Zend\Db\Adapter\Adapter')));
					return $category;
				},
				'Product\Entity\Product' => function  ($sm)
				{
					$entity = new ProductEntity();
					$entity->setTable(new ProductTable($sm->get('Zend\Db\Adapter\Adapter')));
					return $entity;
				},
				'Product\Table\ProductTable' => function  ($sm)
				{
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$productEntity = $sm->get('Product\Entity\Product');

					$brandEntity = $sm->get('Product\Entity\Brand');
					$productEntity->setBrandEntity($brandEntity);

					$categoryEntity = $sm->get('Product\Entity\Category');
					$productEntity->setCategoryEntity($categoryEntity);

					$table = new ProductTable($adapter);
					$table->getResultSetPrototype()
						->setArrayObjectPrototype($productEntity);
					return $table;
				},
				'Product\Table\BrandTable' => function  ($sm)
				{
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$entity = $sm->get('Product\Entity\Brand');
					$table = new BrandTable($adapter);
					$table->getResultSetPrototype()
						->setArrayObjectPrototype($entity);
					return $table;
				},
				'Product\Table\CategoryTable' => function  ($sm)
				{
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$entity = $sm->get('Product\Entity\Category');
					$table = new CategoryTable($adapter);
					$table->getResultSetPrototype()
						->setArrayObjectPrototype($entity);
					return $table;
				}
			)
		);
	}
}