<?php

namespace JL\BannerSlider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use JL\BannerSlider\Model\Banner;
use Magento\Framework\App\Request\DataPersistorInterface;
use JL\BannerSlider\Controller\Adminhtml\Banner\PostDataProcessor;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'JL_BannerSlider::save';

    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor
    )
    {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            // Optimize data
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Banner::STATUS_ENABLED;
            }

            if (empty($data['banner_id'])) {
                $data['banner_id'] = null;
            }

            if (empty($data['images'])) {
                $data['images'] = null;
                $data['image_desktop'] = null;
            } else {
                $data['image_desktop'] = $data['images'][0]['name'];
            }

            if (empty($data['images_mobile'])) {
                $data['images_mobile'] = null;
                $data['image_mobile'] = null;
            } else {
                $data['image_mobile'] = $data['images_mobile'][0]['name'];
            }

            // Init model and load by ID if exists
            $model = $this->_objectManager->create('JL\BannerSlider\Model\Banner');
            $id = $this->getRequest()->getParam('banner_id');
            if ($id) {
                $model->load($id);
            }

            // Validate data
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                // Redirect to Edit page if has error
                return $resultRedirect->setPath('*/*/edit', ['banner_id' => $model->getId(), '_current' => true]);
            }

            // Update model
            $model->setData($data);

            // Save data to database
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the banner.'));
                $this->dataPersistor->clear('banner');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['banner_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the banner.'));
            }

            $this->dataPersistor->set('banner', $data);
            return $resultRedirect->setPath('*/*/edit', ['banner_id' => $this->getRequest()->getParam('banner_id')]);
        }

        // Redirect to List page
        return $resultRedirect->setPath('*/*/');
    }
}