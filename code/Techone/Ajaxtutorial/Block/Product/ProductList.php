<?php

namespace Techone\Ajaxtutorial\Block\Product;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManager;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Pricing\Helper\Data as HelperPrice;

class ProductList extends Template
{
    protected $productCollectionFactory;
    protected $imageHelper;
    protected $listProduct;
    protected $resultJsonFactory;
    protected $priceHelper;

    /**
     * @var Data
     */
    protected $jsonHelper;



    public function __construct(
        Image $imageHelper,
        JsonFactory $resultJsonFactory,
        Context $context,
        CollectionFactory $productCollectionFactory,
        Data $jsonHelper,
        HelperPrice $priceHelper,
        array $data = []
    )
    {
        $this->imageHelper = $imageHelper;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->jsonHelper = $jsonHelper;
        $this->priceHelper = $priceHelper;
        parent::__construct($context, $data);
    }

    public function getProductCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->setPageSize(2);
        $productsData = [];

        if ($collection) {
            foreach ($collection as $product) {
                $itemData = [
                    'entity_id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $this->priceHelper->currency($product->getPrice(), true, false),
                    'src' => $this->imageHelper->init($product, 'product_base_image')->getUrl(),
                    'url' => $product->getProductUrl()
                ];
                array_push($productsData, $itemData);
            }
        }

        $result = $this->jsonHelper->jsonEncode($productsData);
        return $result;
    }
}