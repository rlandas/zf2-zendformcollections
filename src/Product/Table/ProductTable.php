<?php

namespace Product\Table;

use App\Db\AbstractTable;

class ProductTable extends AbstractTable
{

	/**
	 * Name of the table
	 *
	 * @var string
	 */
	protected $table = 'product';

	/**
	 * Primary key of the table
	 *
	 * @var string
	 */
	protected $primaryKey = 'product_id';

	/**
	 * Entity class to associate with the table
	 *
	 * @var string
	 */
	protected $entityClass = 'Product\Entity\Product';
}