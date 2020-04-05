<?php

namespace Nans\StoreLocator\Block\Adminhtml\Widget\Type;

use Magento\Backend\Block\Template;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Editor;
use Magento\Framework\Data\Form\Element\Factory;

class Wysiwyg extends Template
{
    /**
     * @var Config
     */
    protected $wysiwygConfig;

    /**
     * @var Factory
     */
    protected $factoryElement;

    /**
     * @param Context $context
     * @param Factory $factoryElement
     * @param Config $wysiwygConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        Factory $factoryElement,
        Config $wysiwygConfig,
        $data = []
    ) {
        $this->factoryElement = $factoryElement;
        $this->wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element Form Element
     * @return AbstractElement
     */
    public function prepareElementHtml(AbstractElement $element)
    {
        /** @var Editor $editor */
        $editor = $this->factoryElement->create('editor', ['data' => $element->getData()])
            ->setLabel('')
            ->setForm($element->getForm())
            ->setWysiwyg(true)
            ->setConfig(
                $this->wysiwygConfig->getConfig([
                    'add_variables' => false,
                    'add_widgets' => false
                ])
            );

        if ($element->getRequired()) {
            $editor->addClass('required-entry');
        }

        $info = '<br><b>' . __("Use next codes for data auto filling") . ':</b><br>{title} {description} {phone} {country} {city} {state} {street} {zip}';
        $element->setData('after_element_html', $editor->getElementHtml() . $info);
        $element->setValue('');

        return $element;
    }
}