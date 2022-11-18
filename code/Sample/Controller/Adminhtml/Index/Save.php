<?php
/**
 * Copyright © Emipro Technologies Pvt Ltd. All rights reserved.
 * @license http://shop.emiprotechnologies.com/license-agreement/
 */
namespace Emipro\Custom\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Emipro\Custom\Model\Job;
use Magento\Backend\Model\Session;

class Save extends \Magento\Backend\App\Action
{
    protected $Custommodel;
    protected $adminsession;

    public function __construct(
        Action\Context $context,
        Job $Custommodel,
        Session $adminsession
    ) {
        parent::__construct($context);
        $this->Custommodel = $Custommodel;
        $this->adminsession = $adminsession;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $job_id = $this->getRequest()->getParam('job_id');

            if ($job_id) {
                $this->Custommodel->load($job_id);
            }

            $this->Custommodel->setData($data);

            try {
                $this->Custommodel->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath(
                            '*/*/edit',
                            [
                                'job_id' => $this->Custommodel->getJobId(),
                                '_current' => true
                            ]
                        );
                    }
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['job_id' => $this->getRequest()->getParam('job_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
