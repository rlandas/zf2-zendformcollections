<?php

namespace Product\Controller;

use Product\Table\ProductTable;
use Product\Entity\Product as ProductEntity;
use Product\Form\CreateProduct;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\ViewModel;

class ManageController extends AbstractActionController
{

	public function indexAction ()
	{
		$product = $this->getProductTable();
		$products = $product->getAllOrderByName();

		$view = new ViewModel();
		$view->setVariable('products', $products);
		return $view;
	}

	public function viewAction ()
	{
		if ($id = $this->params('id')) {
			$product = $this->getProductTable()
				->getByProductId($id);
		}

		$view = new ViewModel();
		$view->setVariable('product', $product);
		return $view;
	}

	public function addAction ()
	{
		$form = new CreateProduct();
		$product = $this->getServiceLocator()->get('Product\Entity\Product');
		$form->bind($product);

		$data = array(
			'product' => array(
				'name' => 'product name ' . mt_rand(1, 1000),
				'price' => mt_rand(100.000, 5000.999) / 100,
				'brand' => array(
					'name' => 'My brand ' . mt_rand(1, 200),
					'url' => 'http://www.mybrand.com'
				),
				'categories' => array(
					array('name' => 'Sony'),
					array('name' => 'Panasonic'),
					array('name' => 'Phillips')
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
		$brand = $product->getBrand();
		$brandTable = $this->getBrandTable();
		$brand = $brandTable->save($brand);
		$brandId = $brandTable->getLastInsertValue();
		$product->setBrandId($brandId);

		// save the categories
		$categoryTable = $this->getCategoryTable();
		$categoryTable->persist($product->getCategories())->flush();
		$categoryIds = implode(",", $categoryTable->getEntityIds());
		$product->setCategoryIds($categoryIds);

		// save the product
		$productTable = $this->getProductTable();
		$product = $productTable->save($product);

		$this->redirect()->toRoute('product');
		return $view;
	}

	public function editAction ()
	{
		$form = new CreateProduct();
		$product = $this->getServiceLocator()->get('Product\Entity\Product');
		$form->bind($product);

		// action viewscript
		$view = new ViewModel(array(
			'form' => $form
		));

		$productTable = $this->getProductTable();
		if ($id = $this->params('id')) {
			$product = $this->getProductTable()->getByProductId($id);

			// get the brands
			$brand = $this->getBrandTable()->getByBrandId($product->getBrandId());
			$product->setBrand($brand);

			// get the categories
			$categoryIds = explode(",", $product->getCategoryIds());
			$categories = $this->getCategoryTable()->getAllByCategoryId($categoryIds);
			$product->setCategories($categories);

			$form->bind($product);
		}

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


		\Zend\Debug\Debug::dump(__METHOD__.' '.__LINE__);
		\Zend\Debug\Debug::dump($post);
		\Zend\Debug\Debug::dump($product);


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

	/**
	 *
	 * @return \Product\Table\CategoryTable
	 */
	public function getCategoryTable ()
	{
		return $this->getServiceLocator()
			->get('Product\Table\CategoryTable');
	}
}