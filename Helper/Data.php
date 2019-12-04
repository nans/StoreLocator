<?php

namespace Nans\StoreLocator\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\LocalizedException;

class Data extends AbstractHelper
{
    /**
     * @return string
     * @throws LocalizedException
     */
    public function getApiKey(): string
    {
        $value = $this->scopeConfig->getValue('nans_store_location/settings/api_key');
        if (!$value) {
            throw new LocalizedException(__('Store Locator not configured'));
        }

        return $value;
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getApiUrl(): string
    {
        $value = $this->scopeConfig->getValue('nans_store_location/settings/api_url');
        if (!$value) {
            throw new LocalizedException(__('Store Locator not configured'));
        }

        return $value;
    }
}