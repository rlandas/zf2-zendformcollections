<?php

namespace Product\Controller;

use Product\Table\ProductTable;
use Product\Entity\Product;
use Product\Form\CreateProduct;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\ViewModel;

class ManageController extends AbstractActionController
{

	public function indexAction ()
	{
	}

	public function addAction ()
	{
		$form = new CreateProduct();
		$product = new Product();
		$form->bind($product);

		$data = array(
			'product' => array(
				'name' => 'product name ' . mt_rand(1, 1000),
				'price' => mt_rand(100.000, 5000.999) / 100,
				'brand' => array(
					'name' => 'My brand ' . mt_rand(1, 200),
					'url' => 'http://www.mybrand.com'
				)
			)
		);
		$form->populateValues($data);

		// action viewscript
		$view = new ViewModel(array(
			'form' => $form
		));

		// do Post/Redirect/Get (PRG) strategy to stop user refresh/back button
		$prg = $this->prg($this->getRequest()->getRequestUri(), true);
		if ($prg instanceof Response) {
			return $prg;
		}

		// this is when the user first arrives to this url, display the form
		else if ($prg === false) {
			return $view;
		}

		// lets retrieve the post data stored in the PRG session
		$post = $prg;

		// validate the form
		$form->setData($post);
		if(!$form->isValid())
			return $view;

		// if data are valid, then save
		// save the brand
		$brandTable = $this->getBrandTable();
		$brandTable->save($product->getBrand());
		$brandId = $brandTable->getLastInsertValue();

		// pass the brand_id to the product for relational db
		$product->setBrandId($brandId);

		// save the categories

		// save the product
		$productTable = $this->getProductTable();
		$productTable->save($product);

		return $view;
	}

	public function editAction ()
	{
		$form = new CreateProduct();
		$product = new Product();
		$form->bind($product);

		// action viewscript
		$view = new ViewModel(array(
			'form' => $form
		));

		$productTable = $this->getProductTable();
		if ($id = $this->params('id')) {

			\Zend\Debug\Debug::dump(__METHOD__.' '.__LINE__);
			\Zend\Debug\Debug::dump($id);


			/* @var $select \Zend\Db\Sql\Select */
			$result = $productTable->select(function($select) use ($id){
				$select->where(array('product_id = ?' => $id));
				// \Zend\Debug\Debug::dump($select->getSqlString());
			});


			\Zend\Debug\Debug::dump(__METHOD__.' '.__LINE__);
			\Zend\Debug\Debug::dump($result->current());
		}


		if ($this->request->isPost()) {
			$form->setData($this->request->getPost());

			if ($form->isValid()) {
				\Zend\Debug\Debug::dump($product);
			}
		}

		return $view;
	}

	/**
	 *
	 * @return \Product\Table\ProductTable
	 */
	public function getProductTable ()
	{
		$sm = $this->getServiceLocator();
		$table = $sm->get('Product\Table\ProductTable');
		return $table;
	}

	/**
	 *
	 * @return \Product\Table\BrandTable
	 */
	public function getBrandTable ()
	{
		return $this->getServiceLocator()
			->get('Product\Table\BrandTable');
	}

	public function getCategoryTable ()
	{
	}
}