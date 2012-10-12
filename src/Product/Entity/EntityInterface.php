<?php

namespace Product\Entity;

interface EntityInterface
{

	/**
	 * Get the primary key id of the entity
	 */
	public function getId ();

	/**
	 * Set the primary key id of the entity
	 */
	public function setId ($id);

	public function exchangeArray ();

	public function toArray ();

	public function populate (array $rowData);
}