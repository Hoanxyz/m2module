<?php

namespace JL\BannerSlider\ResourceModel\Banner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use JL\BannerSlider\Model\ResourceModel\Banner as ResourceBanner;
use JL\BannerSlider\Model\Banner as BannerModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(BannerModel::class, ResourceBanner::class);
    }
}