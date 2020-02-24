<?php
namespace Apptha\Marketplace\Model\Api;
use Apptha\Marketplace\Api\SellerManagementInterface;


class Seller implements SellerManagementInterface
{

    protected $categoryDataFactory;
	
	protected $categoryFactory;
	
	protected $sellerFactory;
	
	protected $sellerDataFactory;
	
	
    public function __construct(
	\Apptha\Marketplace\Api\Data\CategoryDataInterfaceFactory $categoryDataFactory ,
	\Apptha\Marketplace\Model\CategoryFactory $categoryFactory ,
	\Apptha\Marketplace\Model\SellerFactory $sellerFactory,
	\Apptha\Marketplace\Api\Data\SellerDataInterfaceFactory $sellerDataFactory
	
	)
    {
		$this->sellerFactory = $sellerFactory;
		$this->sellerDataFactory = $sellerDataFactory;
        $this->categoryDataFactory = $categoryDataFactory;
		$this->categoryFactory = $categoryFactory;
    }
	
	
    /**
     * Returns greeting message to user
     *
     * @api
     * @param int $sellerId Seller Id.
	 * @param int $page
	 * @param int $limit
     * @return string Greeting message with users name.
     */
    public function getCategories($sellerId , $page = 1 , $limit = 20) {
        $categories = $this->categoryFactory->create()->getCollection()->addFieldToFilter('seller_id' , $sellerId)->setOrder('id', 'desc')->setCurPage($page)->setPageSize($limit);
		$data = array();
		foreach($categories as $category){
			$category_data_object = $this->categoryDataFactory->create();
        	$category_data_object->setCategoryName($category->getCategoryName());
			$category_data_object->setId($category->getId());
			$category_data_object->setStoreId($category->getStoreId());
			$category_data_object->setStatus($category->getStatus());
			$category_data_object->setParentCategoryId($category->getParentCategoryId());
			$category_data_object->setMageCategoryId($category->getMageCategoryId());
			$category_data_object->setCategoryStatus($category->getCategoryStatus());
			$data[] = $category_data_object;
		}
		return $data;
    }
	
	
	/**
	 * GET for Seller Data api
	 * @param int $sellerId 
	 * @return Apptha\Marketplace\Api\Data\SellerDataInterface
	 */
	public function getDetails($sellerId){
		$seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('id' , $sellerId);
		
		if($seller->getSize()){
			$seller = $seller->getFirstItem();
			//echo $seller->getId();exit;
			try{
				$seller_data_object = $this->sellerDataFactory->create();
				$seller_data_object->setId($seller->getId());
				$seller_data_object->setEmail($seller->getEmail());
				$seller_data_object->setStatus($seller->getStatus());
				$seller_data_object->setFacebookId($seller->getFacebookId());
				$seller_data_object->setTwitterId($seller->getTwitterId());
				$seller_data_object->setGoogleId($seller->getGoogleId());
				$seller_data_object->setLinkedId($seller->getLinkedId());
				$seller_data_object->setDesc($seller->getDesc());
				$seller_data_object->setStoreName($seller->getStoreName());
				$seller_data_object->setContact($seller->getContact());
				$seller_data_object->setCommission($seller->getCommission());				
				$seller_data_object->setCountry($seller->getCountry());
				$seller_data_object->setState($seller->getState());
				$seller_data_object->setLogoName($seller->getLogoName());
				$seller_data_object->setBannerName($seller->getBannerName());
				$seller_data_object->setStoreUrl($seller->getStoreUrl());
				$seller_data_object->setShowProfile($seller->getShowProfile());
				$seller_data_object->setAddress($seller->getAddress());
				$seller_data_object->setNationalShippinhAmount($seller->getNationalShippingAmount());
				$seller_data_object->setInternationalShippingAmount($seller->getInternationalShippinhAmount());
				
				return $seller_data_object;
			}catch (\Exception $e) {
		        echo $e->getMessage(); exit;
		    }
					
			
		}
	}
}