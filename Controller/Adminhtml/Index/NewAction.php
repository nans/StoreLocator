<?php

namespace Nans\StoreLocator\Controller\Adminhtml\Price;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Backend\App\Action;

class NewAction extends Action
{
    /**
     * @var Forward
     */
    protected $resultForwardFactory;

    const ADMIN_RESOURCE = 'Nans_StoreLocator::admin_location_create';

    /**
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * @return Forward
     */
    public function execute()
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}
