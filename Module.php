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
				'Product\Entity\Product' => function  ($sm)
				{
					$entity = new ProductEntity();

					$brand = new BrandEntity();
					$entity->setBrand($brand);

					$category = new CategoryEntity();
					$entity->setCategories($category);

					return $entity;
				},
				'Product\Table\ProductTable' => function  ($sm)
				{
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$table = new ProductTable($adapter);
					$table->getResultSetPrototype()
						->setArrayObjectPrototype(new ProductEntity());
					return $table;
				},
				'Product\Table\BrandTable' => function  ($sm)
				{
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$table = new BrandTable($adapter);
					$table->getResultSetPrototype()
						->setArrayObjectPrototype(new BrandEntity());
					return $table;
				},
				'Product\Table\CategoryTable' => function  ($sm)
				{
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$table = new CategoryTable($adapter);
					$table->getResultSetPrototype()
						->setArrayObjectPrototype(new CategoryEntity());
					return $table;
				}
			)
		);
	}
}