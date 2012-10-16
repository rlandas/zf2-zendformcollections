<?php

namespace Product\Form;

use Zend\Stdlib\Hydrator\ArraySerializable;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\Stdlib\Hydrator\ArraySerializable as ArraySerializableHydrator;

class CreateProduct extends Form
{

	public function __construct ()
	{
		parent::__construct('create_product');

		$this->setAttribute('method', 'post')
			->setHydrator(new ArraySerializableHydrator())
			->setInputFilter(new InputFilter());

		$this->add(array(
			'type' => 'Product\Form\ProductFieldset',
			'options' => array(
				'use_as_base_fieldset' => true
			)
		));

		$this->add(array(
			'type' => 'Zend\Form\Element\Csrf',
			'name' => 'csrf'
		));

		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Submit'
			)
		));
	}
}