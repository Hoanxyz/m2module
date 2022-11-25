<?php

namespace JL\BannerSlider\Model;

use Magento\Framework\Model\AbstractModel;

use JL\BannerSlider\Model\ResourceModel\Banner as ResourceBanner;

class Banner extends AbstractModel
{
    /**
     * Banner's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected function _construct()
    {
        $this->_init(ResourceBanner::class);
    }

    /**
     * Prepare banner's statuses.
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}