<?php
/**
 * Copyright © Emipro Technologies Pvt Ltd. All rights reserved.
 * @license http://shop.emiprotechnologies.com/license-agreement/
 */
namespace Emipro\Custom\Model;

use Magento\Framework\Model\AbstractModel;
use Emipro\Custom\Model\ResourceModel\Job as JobResourceModel;

class Job extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(JobResourceModel::class);
    }
}
