<?php
namespace Techone\Ajaxtutorial\Controller\Test;

use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Store\Model\StoreManager;
use Magento\Framework\Controller\Result\JsonFactory;

class Product extends \Magento\Framework\App\Action\Action
{
    protected $productFactory;
    protected $imageHelper;
    protected $listProduct;
    protected $_storeManager;
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        ProductFactory $productFactory,
        StoreManager $storeManager,
        Image $imageHelper,
        JsonFactory $resultJsonFactory
    )
    {
        $this->productFactory = $productFactory;
        $this->imageHelper = $imageHelper;
        $this->_storeManager = $storeManager;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function getCollection()
    {
        return $this->productFactory->create()
            ->getCollection()
            ->addAttributeToSelect('*')
            ->setPageSize(2);
    }

    public function execute()
    {
        $productsData = [];
        if ($this->getCollection()) {
            foreach ($this->getCollection() as $product) {
                $itemData = [
                    'entity_id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'src' => $this->imageHelper->init($product, 'product_base_image')->getUrl(),
                    'url' => $product->getProductUrl()
                ];
                array_push($productsData, $itemData);
            }
        }

        $result = $this->resultJsonFactory->create();
        $result->setData($productsData);
        return $result;
   }
}