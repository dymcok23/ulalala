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
namespace ShippingApps\PocztexRate\Model\Config\Backend;

use Magento\Framework\Model\AbstractModel;

/**
 * Backend model for shipping table rates CSV importing
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Pocztexrate extends \Magento\Framework\App\Config\Value
{
    /**
     * @var \ShippingApps\PocztexRate\Model\ResourceModel\Carrier\PocztexrateFactory
     */
    protected $pocztexrateFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \ShippingApps\PocztexRate\Model\ResourceModel\Carrier\PocztexrateFactory $pocztexrateFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \ShippingApps\PocztexRate\Model\ResourceModel\Carrier\PocztexrateFactory $pocztexrateFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->pocztexrateFactory = $pocztexrateFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * @return \Magento\Framework\Model\AbstractModel|void
     */
    public function afterSave()
    {
        /** @var \ShippingApps\PocztexRate\Model\ResourceModel\Carrier\Pocztexrate $pocztexRate */
        $pocztexRate = $this->pocztexrateFactory->create();
        $pocztexRate->uploadAndImport($this);
        return parent::afterSave();
    }
}
