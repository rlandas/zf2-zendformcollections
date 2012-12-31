<?php

namespace Product\Form;

use Product\Entity\Brand;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\Stdlib\Hydrator\ArraySerializable as ArraySerializableHydrator;

class BrandFieldset extends Fieldset implements InputFilterProviderInterface
{

	public function __construct ()
	{
		parent::__construct('brand');
		$this->setHydrator(new ArraySerializableHydrator())// new ClassMethodsHydrator(false))
			->setObject(new Brand());

		$this->setLabel('Brand');

		$this->add(array(
			'name' => 'name',
			'options' => array(
				'label' => 'Name of the brand'
			),
			'attributes' => array(
// 				'required' => 'required'
			)
		));

		$this->add(array(
			'name' => 'url',
			'type' => 'Zend\Form\Element\Url',
			'options' => array(
				'label' => 'Website of the brand'
			),
			'attributes' => array(
// 				'required' => 'required'
			)
		));
	}

	/**
	 *
	 * @return array
	 */
	public function getInputFilterSpecification ()
	{
		return array(
			'name' => array(
				'required' => true
			)
		);
	}
}