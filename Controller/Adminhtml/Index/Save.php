<?php

namespace Nans\StoreLocator\Controller\Adminhtml\Index;

use Throwable;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Nans\StoreLocator\Api\Data\LocationInterface;
use Nans\StoreLocator\Api\LocationRepositoryInterface;
use Nans\StoreLocator\Model\Location;
use Nans\StoreLocator\Model\LocationFactory;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Nans_StoreLocator::admin_location_create';

    /**
     * @var LocationRepositoryInterface
     */
    private $locationRepository;

    /**
     * @var LocationFactory
     */
    private $locationFactory;

    /**
     * @param Action\Context $context
     * @param LocationRepositoryInterface $locationRepository
     * @param LocationFactory $locationFactory
     */
    public function __construct(
        Action\Context $context,
        LocationRepositoryInterface $locationRepository,
        LocationFactory $locationFactory
    ) {
        parent::__construct($context);
        $this->locationRepository = $locationRepository;
        $this->locationFactory = $locationFactory;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam(LocationInterface::KEY_ID);
        $data = $this->getRequest()->getParams();
        if (is_array($data) && key_exists(LocationInterface::KEY_STORE_IDS, $data) && is_array($data[LocationInterface::KEY_STORE_IDS])) {
            $data[LocationInterface::KEY_STORE_IDS] = implode(",", $data[LocationInterface::KEY_STORE_IDS]);
        }

        /** @var Location $location */
        if ($id) {
            $location = $this->locationRepository->getById($id);
        } else {
            unset($data[LocationInterface::KEY_ID]);
            $location = $this->locationFactory->create();
        }

        unset($data[LocationInterface::KEY_UPDATE_TIME]);
        $location->setData($data);

        try {
            $this->locationRepository->save($location);
            $this->messageManager->addSuccessMessage(__('Location saved successfully'));

            if (key_exists('back', $data) && $data['back'] == 'edit') {

                return $resultRedirect->setPath('*/*/edit', ['id' => $id, '_current' => true]);
            }

            return $resultRedirect->setPath('*/*/');
        } catch (Throwable $throwable) {
            $this->messageManager->addErrorMessage(__("Location was not saved"));

            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
    }
}