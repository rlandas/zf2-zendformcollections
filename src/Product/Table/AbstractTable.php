<?php

namespace Product\Table;

use Product\Entity\EntityInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\TableGateway\Feature\MetadataFeature;
use Zend\Db\TableGateway\Feature\FeatureSet;

class AbstractTable extends AbstractTableGateway
{

	/**
	 * Stores the data for each row in the table
	 *
	 * @var array
	 */
	protected $_data = array();

	public function __construct (Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();

		// lets add some features to this table
		$this->featureSet = new FeatureSet();

		// add the metadata features to this table
		$this->featureSet->addFeature(new MetadataFeature());

		// add the row gateway feature
		$this->featureSet->addFeature(new RowGatewayFeature());

		$this->initialize();
	}

	/**
	 * Save the entity into a row in the database table
	 * @param EntityInterface $entity
	 */
	public function save (EntityInterface $entity)
	{
		$data = $this->setFromArray($entity);
		if (!$id = (int) $entity->getId()) {
			// this is a new row
			$this->insert($this->_data);
		}

		else {
			// this is an update of an existing row
			\Zend\Debug\Debug::dump(__METHOD__ . ' ' . __LINE__);
			\Zend\Debug\Debug::dump($data);

		}
	}

	/**
	 * Sets all data in the row from an array
	 *
	 * @param array|Entity\EntityInterface $data
	 * @return \Product\Table\AbstractTable
	 */
	public function setFromArray ($data)
	{
		if ($data instanceof EntityInterface)
			$data = $data->toArray();
		$columns = $this->getColumns();
		$columns = array_combine($columns, $columns);
		$this->_data = array_intersect_key($data, $columns);
		return $this;
	}
}