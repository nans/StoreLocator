<?php

namespace Nans\StoreLocator\Controller\Adminhtml\Index;

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
     * @param LocationRepositoryInterface $reviewRepository
     * @param LocationFactory $reviewFactory
     */
    public function __construct(
        Action\Context $context,
        LocationRepositoryInterface $reviewRepository,
        LocationFactory $reviewFactory
    ) {
        parent::__construct($context);
        $this->locationRepository = $reviewRepository;
        $this->locationFactory = $reviewFactory;
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

        /** @var Location $review */
        if ($id) {
            $review = $this->locationRepository->getById($id);
        } else {
            unset($data[LocationInterface::KEY_ID]);
            $review = $this->locationFactory->create();
        }

        unset($data[LocationInterface::KEY_UPDATE_TIME]);
        $review->setData($data);

        try {
            $this->locationRepository->save($review);
            $this->messageManager->addSuccessMessage(__('Location saved successfully'));

            if (key_exists('back', $data) && $data['back'] == 'edit') {

                return $resultRedirect->setPath('*/*/edit', ['id' => $id, '_current' => true]);
            }

            return $resultRedirect->setPath('*/*/');
        } catch (\Throwable $throwable) {
            $this->messageManager->addErrorMessage(__("Location was not saved"));

            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
    }
}