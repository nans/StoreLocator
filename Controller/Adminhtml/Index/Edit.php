<?php

namespace Nans\StoreLocator\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Registry;
use Nans\RequestPrice\Api\Data\RequestInterface;
use Nans\StoreLocator\Api\Data\LocationInterface;
use Nans\StoreLocator\Api\LocationRepositoryInterface;
use Nans\StoreLocator\Helper\Constants;
use Nans\StoreLocator\Model\LocationFactory;

class Edit extends Action
{
    /**
     * @var LocationRepositoryInterface
     */
    private $locationRepository;

    /**
     * @var LocationFactory
     */
    private $locationFactory;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @param Context $context
     * @param LocationRepositoryInterface $locationRepository
     * @param LocationFactory $locationFactory
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        LocationRepositoryInterface $locationRepository,
        LocationFactory $locationFactory,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->locationRepository = $locationRepository;
        $this->locationFactory = $locationFactory;
        $this->registry = $registry;
    }

    /**
     * Edit record data
     *
     * @return Page|Redirect
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(Constants::FRONTEND_ID);

        /** @var RequestInterface|AbstractModel $model */
        if ($id) {
            $model = $this->locationRepository->getById($id);
            if (!$model->getId()) {
                $this->getMessageManager()->addErrorMessage(__('This location no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $model = $this->locationFactory->create();
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->registry->register('location', $model);

        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $this->_initAction($resultPage, $model);
    }

    /**
     * @param Page $resultPage
     * @param LocationInterface $model
     * @return Page
     */
    protected function _initAction(Page $resultPage, LocationInterface $model)
    {
        $id = $model->getId();
        $resultPage->addBreadcrumb(__('Location'), __('Location'))->addBreadcrumb(__('Manage'), __('Manage'));
        $resultPage->addBreadcrumb($id ? __('Edit') : __('New'), $id ? __('Edit') : __('New'));
        $resultPage->getConfig()->getTitle()->prepend(__('Location'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New location'));

        return $resultPage;
    }
}