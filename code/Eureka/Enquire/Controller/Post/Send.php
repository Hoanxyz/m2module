<?php

namespace Eureka\Enquire\Controller\Post;

use Magento\Framework\Controller\ResultFactory;

class Send extends \Magento\Framework\App\Action\Action
{

    /*
    * @var $resultRedirect
    * @var $formFactory
    * @var $_customerSession;
    */

    private $helperEmail;
    protected $resultPageFactory;
    protected $messageManager;

    /*
    * @param Action\Context $context
    * @param FormFactory $formFactory
    */

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Eureka\Enquire\Helper\Email $helperEmail
    ) {
        $this->helperEmail = $helperEmail;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $templateId = 'email_enquire_template';

        $data = $this->getRequest()->getPost();

        try {
            if (!empty($data)) {
                $this->helperEmail->sendEmail($templateId, $data);
                $this->messageManager->addSuccessMessage(__("Your inquiry was sent successfully."));
            }

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('Something went wrong while sending your enquire.')
            );
        }
    }
}
