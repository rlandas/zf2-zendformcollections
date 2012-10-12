<?php

namespace Product;

use Product\Entity\Brand;
use Product\Entity\Product;
use Product\Table\BrandTable;
use Product\Table\ProductTable;

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
				'Product\Table\ProductTable' => function  ($sm)
				{
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$table = new ProductTable($adapter);
					$table->getResultSetPrototype()
						->setArrayObjectPrototype(new Product());
					return $table;
				},
				'Product\Table\BrandTable' => function  ($sm)
				{
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$table = new BrandTable($adapter);
					$table->getResultSetPrototype()
						->setArrayObjectPrototype(new Brand());
					return $table;
				}
			)
		);
	}
}