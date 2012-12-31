<?php

namespace Product\Table;

use App\Db\AbstractTable;

class BrandTable extends AbstractTable
{

	/**
	 * Name of the table
	 *
	 * @var string
	 */
	protected $table = 'brand';

	/**
	 * Primary key of the table
	 *
	 * @var string
	 */
	protected $primaryKey = 'brand_id';

	/**
	 * Entity class to associate with the table
	 *
	 * @var string
	 */
	protected $entityClass = 'Product\Entity\Brand';
}