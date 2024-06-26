<?php

namespace Magebit\Faq\Model\Question\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magebit\Faq\Model\Question;

class Status implements OptionSourceInterface
{
    /**
     * @var Question
     */
    protected $question;

    /**
     * Constructor
     *
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->question->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
