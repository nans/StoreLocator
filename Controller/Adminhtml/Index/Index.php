<?php

namespace Nans\StoreLocator\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Nans_StoreLocator::admin_index';

    const MENU_ID = 'Nans_StoreLocator::admin_list';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Details constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;

        parent::__construct($context);
    }

    /**
     * Bulk list action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->initLayout();
        $this->_setActiveMenu(self::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('Store Locations'));

        return $resultPage;
    }

}
