<?php

namespace JL\BannerSlider\Model\Banner;

use JL\BannerSlider\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $loadedData;
    protected $collection;
    protected $storeManager;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $data = $item->getData();

            if ($data['image_desktop'] != null) {
                $imageDesktop = $data['image_desktop'];
                $data['images'][0]['url'] = $this->storeManager->getStore()->getBaseUrl(
                        UrlInterface::URL_TYPE_MEDIA
                    ) . 'jl/bannerslider/banner/images/' . $imageDesktop;
                $data['images'][0]['name'] = $imageDesktop;
            }

            if ($data['image_mobile'] != null) {
                $imageMobile = $data['image_mobile'];
                $data['images_mobile'][0]['url'] = $this->storeManager->getStore()->getBaseUrl(
                        UrlInterface::URL_TYPE_MEDIA
                    ) . 'jl/bannerslider/banner/images/' . $imageMobile;
                $data['images_mobile'][0]['name'] = $imageMobile;
            }

            $this->loadedData[$item->getId()] = $data;
        }
        return $this->loadedData;
    }
}