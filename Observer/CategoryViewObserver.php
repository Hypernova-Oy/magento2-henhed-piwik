<?php
/**
 * Copyright 2016-2018 Henrik Hedelund
 *
 * This file is part of Henhed_Piwik.
 *
 * Henhed_Piwik is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Henhed_Piwik is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Henhed_Piwik.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Henhed\Piwik\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Observer for `catalog_controller_category_init_after'
 *
 */
class CategoryViewObserver implements ObserverInterface
{

    /**
     * Piwik tracker instance
     *
     * @var \Henhed\Piwik\Model\Tracker
     */
    protected $_piwikTracker;

    /**
     * Piwik data helper
     *
     * @var \Henhed\Piwik\Helper\Data $_dataHelper
     */
    protected $_dataHelper;

    /**
     * Constructor
     *
     * @param \Henhed\Piwik\Model\Tracker $piwikTracker
     * @param \Henhed\Piwik\Helper\Data $dataHelper
     */
    public function __construct(
        \Henhed\Piwik\Model\Tracker $piwikTracker,
        \Henhed\Piwik\Helper\Data $dataHelper
    ) {
        $this->_piwikTracker = $piwikTracker;
        $this->_dataHelper = $dataHelper;
    }

    /**
     * Push EcommerceView to tracker on category view page
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return \Henhed\Piwik\Observer\CategoryViewObserver
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->_dataHelper->isTrackingEnabled()) {
            return $this;
        }

        $category = $observer->getEvent()->getCategory();
        /** @var \Magento\Catalog\Model\Category $category */

        $this->_piwikTracker->setEcommerceView(
            false,
            false,
            $category->getName()
        );

        return $this;
    }
}
