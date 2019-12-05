<?php

namespace Nans\StoreLocator\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Nans\StoreLocator\Api\LocationRepositoryInterface;
use Nans\StoreLocator\Helper\Constants;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Nans_StoreLocator::admin_location_delete';

    /**
     * @var LocationRepositoryInterface
     */
    private $locationRepository;

    /**
     * @param Context $context
     * @param LocationRepositoryInterface $locationRepository
     */
    public function __construct(
        Context $context,
        LocationRepositoryInterface $locationRepository
    ) {
        parent::__construct($context);
        $this->locationRepository = $locationRepository;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(Constants::FRONTEND_ID);
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->locationRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The record has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', [Constants::FRONTEND_ID => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a record to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}