<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace JL\BannerSlider\Controller\Adminhtml\Banner;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use Magento\Staging\Controller\Result\JsonFactory;
use JL\BannerSlider\Model\BannerFactory;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'JL_BannerSlider::save';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $jsonFactory;

    /**
     * @var BannerFactory
     */
    protected $bannerFactory;

    /**
     * @param Action\Context $context
     * @param JsonFactory $jsonFactory
     * @param \Magento\Framework\Registry $registry
     * @param BannerFactory $bannerFactory
     */
    public function __construct(
        Action\Context $context,
        JsonFactory $jsonFactory,
        \Magento\Framework\Registry $registry,
        BannerFactory $bannerFactory

    ) {
        $this->jsonFactory = $jsonFactory;
        $this->_coreRegistry = $registry;
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context);
    }

    /**
     * Edit CMS page
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $bannerId) {
                    $banner = $this->bannerFactory->create()->load($bannerId);
                    try {
                        $banner->setData(array_merge($banner->getData(), $postItems[$bannerId]));
                        $banner->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Customform ID: {$bannerId}] {$e->getMessage()}";
                        $error = true;
                    }
                }
            }

            return $resultJson->setData([
                'messages' => $messages,
                'error' => $error
            ]);
        }
    }
}
