<?php

namespace Magebit\PageListWidget\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as PageCollectionFactory;

class PageList implements OptionSourceInterface
{
    /**
     * @var PageCollectionFactory
     */
    protected $pageCollectionFactory;

    /**
     * @param PageCollectionFactory $pageCollectionFactory
     */
    public function __construct(PageCollectionFactory $pageCollectionFactory)
    {
        $this->pageCollectionFactory = $pageCollectionFactory;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [];
        $pages = $this->pageCollectionFactory->create()->addFieldToFilter('is_active', 1)->setOrder('title', 'ASC');

        foreach ($pages as $page) {
            $options[] = ['value' => $page->getId(), 'label' => $page->getTitle()];
        }

        return $options;
    }
}
