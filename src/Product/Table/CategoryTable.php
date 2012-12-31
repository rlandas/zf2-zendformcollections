<?php

namespace Product\Table;

use App\Db\AbstractTable;

class CategoryTable extends AbstractTable
{

	/**
	 * Name of the table
	 *
	 * @var string
	 */
	protected $table = 'category';

	/**
	 * Primary key of the table
	 *
	 * @var string
	 */
	protected $primaryKey = 'category_id';

	/**
	 * Entity class to associate with the table
	 *
	 * @var string
	 */
	protected $entityClass = 'Product\Entity\Category';
}