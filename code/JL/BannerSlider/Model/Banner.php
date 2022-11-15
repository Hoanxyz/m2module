<?php

namespace JL\BannerSlider\Model;

use Magento\Framework\Model\AbstractModel;

use JL\BannerSlider\Model\ResourceModel\Banner as ResourceBanner;

class Banner extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceBanner::class);
    }
}