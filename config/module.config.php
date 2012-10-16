<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Product\Controller\Manage' => 'Product\Controller\ManageController'
		)
	),

	'router' => array(
		'routes' => array(
			'product' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/product[/][:action][/][:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+'
					),
					'defaults' => array(
						'controller' => 'Product\Controller\Manage',
						'action' => 'index'
					)
				)
			)
		)
	),

	'view_manager' => array(
		'template_path_stack' => array(
			'product' => __DIR__ . '/../view'
		)
	)
);