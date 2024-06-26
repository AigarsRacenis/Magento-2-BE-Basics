<?php

namespace Magebit\Faq\Ui\Component\Form\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magebit\Faq\Ui\Component\Form\Button\GenericButton;

/**
 * Class BackButton
 */
class Back extends GenericButton implements ButtonProviderInterface
{
    /**
     * Gets the button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}
