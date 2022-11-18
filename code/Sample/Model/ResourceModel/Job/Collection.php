<?php
/**
 * Copyright © Emipro Technologies Pvt Ltd. All rights reserved.
 * @license http://shop.emiprotechnologies.com/license-agreement/
 */

namespace Emipro\Custom\Model\ResourceModel\Job;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Emipro\Custom\Model\Job as JobModel;
use Emipro\Custom\Model\ResourceModel\Job as JobResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            JobModel::class,
            JobResourceModel::class
        );
    }
}
