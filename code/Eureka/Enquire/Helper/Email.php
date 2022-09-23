<?php

namespace Eureka\Enquire\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $logger;

    /**
     * @param \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->logger = $context->getLogger();
    }

    public function sendEmail($templateId, $data)
    {
        try {
            $this->inlineTranslation->suspend();

            $sender = [
                'name' => $data['name'],
                'email' => $data['email']
            ];

            $storeId = $this->storeManager->getStore()->getId();

            $templateVar = [
                'name' => $this->escaper->escapeHtml($data['name']),
                'company' => $this->escaper->escapeHtml($data['company']),
                'phonenumber' => $this->escaper->escapeHtml($data['phonenumber']),
                'email' => $this->escaper->escapeHtml($data['email']),
                'question' => $this->escaper->escapeHtml($data['question'])
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($templateId)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' =>  $storeId,
                    ]
                )
                ->setTemplateVars($templateVar)
                ->setFrom($sender)
                ->addTo($this->getEmailEnquire())
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    public function getEmailEnquire() {
        return $this->scopeConfig->getValue('enquire_setting/email/to_email', ScopeInterface::SCOPE_STORE) ?: 'sales@eurekaphysiocare.com';
    }
}
