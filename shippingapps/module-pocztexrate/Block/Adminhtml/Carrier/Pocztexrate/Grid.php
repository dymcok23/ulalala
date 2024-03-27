<?php
/**
 * ShippingApps
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * ShippingApps PocztexRate
 *
 * @category ShippingApps
 * @package ShippingApps_PocztexRate
 * @copyright Copyright (c) 2014 Zowta LLC (http://www.ShippingApps.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @author ShippingApps Team sales@shippingapps.com
 *
 */
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShippingApps\PocztexRate\Block\Adminhtml\Carrier\Pocztexrate;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Website filter
     *
     * @var int
     */
    protected $websiteId;

    /**
     * Condition filter
     *
     * @var string
     */
    protected $conditionName;

    /**
     * @var \ShippingApps\PocztexRate\Model\Carrier\Pocztexrate
     */
    protected $pocztexrate;

    /**
     * @var \ShippingApps\PocztexRate\Model\ResourceModel\Carrier\Pocztexrate\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \ShippingApps\PocztexRate\Model\ResourceModel\Carrier\Pocztexrate\CollectionFactory $collectionFactory
     * @param \ShippingApps\PocztexRate\Model\Carrier\Pocztexrate $pocztexrate
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \ShippingApps\PocztexRate\Model\ResourceModel\Carrier\Pocztexrate\CollectionFactory $collectionFactory,
        \ShippingApps\PocztexRate\Model\Carrier\Pocztexrate $pocztexrate,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->pocztexrate = $pocztexrate;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Define grid properties
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('shippingPocztexrateGrid');
        $this->_exportPageSize = 10000;
    }

    /**
     * Set current website
     *
     * @param int $websiteId
     * @return $this
     */
    public function setWebsiteId($websiteId)
    {
        $this->websiteId = $this->_storeManager->getWebsite($websiteId)->getId();
        return $this;
    }

    /**
     * Retrieve current website id
     *
     * @return int
     */
    public function getWebsiteId()
    {
        if ($this->websiteId === null) {
            $this->websiteId = $this->_storeManager->getWebsite()->getId();
        }
        return $this->websiteId;
    }

    /**
     * Set current website
     *
     * @param string $name
     * @return $this
     */
    public function setConditionName($name)
    {
        $this->conditionName = $name;
        return $this;
    }

    /**
     * Retrieve current website id
     *
     * @return int
     */
    public function getConditionName()
    {
        return $this->conditionName;
    }

    /**
     * Prepare shipping table rate collection
     *
     * @return \ShippingApps\PocztexRate\Block\Adminhtml\Carrier\Pocztexrate\Grid
     */
    protected function _prepareCollection()
    {
        /** @var $collection \ShippingApps\PocztexRate\Model\ResourceModel\Carrier\Pocztexrate\Collection */
        $collection = $this->collectionFactory->create();
        $collection->setConditionFilter($this->getConditionName())->setWebsiteFilter($this->getWebsiteId());

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare table columns
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'dest_country',
            ['header' => __('Country'), 'index' => 'dest_country', 'default' => '*']
        );

        $this->addColumn(
            'dest_region',
            ['header' => __('Region/State'), 'index' => 'dest_region', 'default' => '*']
        );
        $this->addColumn(
            'dest_city',
            ['header' => __('City'), 'index' => 'dest_city', 'default' => '*']
        );
        $this->addColumn(
            'dest_zip',
            ['header' => __('Zip/Postal Code From'), 'index' => 'dest_zip', 'default' => '*']
        );
        $this->addColumn(
            'dest_zip_to',
            ['header' => __('Zip/Postal Code To'), 'index' => 'dest_zip_to', 'default' => '*']
        );

        $label = $this->pocztexrate->getCode('condition_name_short', $this->getConditionName());

        $this->addColumn(
            'condition_from_value',
            ['header' => $label.__('>'), 'index' => 'condition_from_value']
        );

        $this->addColumn(
            'condition_to_value',
            ['header' => $label.__('<='), 'index' => 'condition_to_value']
        );

        $this->addColumn('price', ['header' => __('Shipping Price'), 'index' => 'price']);

        $this->addColumn(
            'shipping_method',
            ['header' => __('Shipping Method'), 'index' => 'shipping_method']
        );

        return parent::_prepareColumns();
    }
}
