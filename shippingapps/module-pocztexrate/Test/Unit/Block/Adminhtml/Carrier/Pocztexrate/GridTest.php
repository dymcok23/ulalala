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

namespace ShippingApps\PocztexRate\Test\Unit\Block\Adminhtml\Carrier\Pocztexrate;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    /**
     * @var \ShippingApps\PocztexRate\Block\Adminhtml\Carrier\Pocztexrate\Grid
     */
    protected $model;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeManagerMock;

    /**
     * @var \Magento\Backend\Helper\Data|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $backendHelperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $pocztexrateMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $context;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $collectionFactoryMock;

    /** @var ObjectManagerHelper */
    protected $objectManagerHelper;

    protected function setUp(): void
    {
        $this->objectManagerHelper = new ObjectManagerHelper($this);

        $this->storeManagerMock = $this->getMockBuilder('Magento\Store\Model\StoreManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->context = $this->objectManagerHelper->getObject('Magento\Backend\Block\Template\Context', [
            'storeManager' => $this->storeManagerMock
        ]);

        $this->backendHelperMock = $this->getMockBuilder('\Magento\Backend\Helper\Data')
            ->disableOriginalConstructor()
            ->getMock();

        $this->collectionFactoryMock =
            $this->getMockBuilder('\ShippingApps\PocztexRate\Model\ResourceModel\Carrier\Pocztexrate\CollectionFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $this->pocztexrateMock = $this->getMockBuilder('ShippingApps\PocztexRate\Model\Carrier\Pocztexrate')
            ->disableOriginalConstructor()
            ->getMock();

        $this->model = new \ShippingApps\PocztexRate\Block\Adminhtml\Carrier\Pocztexrate\Grid(
            $this->context,
            $this->backendHelperMock,
            $this->collectionFactoryMock,
            $this->pocztexrateMock
        );
    }

    public function testSetWebsiteId()
    {
        $websiteId = 1;

        $websiteMock = $this->getMockBuilder('Magento\Store\Model\Website')
            ->setMethods(['getId'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeManagerMock->expects($this->once())
            ->method('getWebsite')
            ->with($websiteId)
            ->willReturn($websiteMock);

        $websiteMock->expects($this->once())
            ->method('getId')
            ->willReturn($websiteId);

        $this->assertSame($this->model, $this->model->setWebsiteId($websiteId));
        $this->assertEquals($websiteId, $this->model->getWebsiteId());
    }

    public function testGetWebsiteId()
    {
        $websiteId = 10;

        $websiteMock = $this->getMockBuilder('Magento\Store\Model\Website')
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();

        $websiteMock->expects($this->once())
            ->method('getId')
            ->willReturn($websiteId);

        $this->storeManagerMock->expects($this->once())
            ->method('getWebsite')
            ->willReturn($websiteMock);

        $this->assertEquals($websiteId, $this->model->getWebsiteId());

        $this->storeManagerMock->expects($this->never())
            ->method('getWebsite')
            ->willReturn($websiteMock);

        $this->assertEquals($websiteId, $this->model->getWebsiteId());
    }

    public function testSetAndGetConditionName()
    {
        $conditionName = 'someName';
        $this->assertEquals($this->model, $this->model->setConditionName($conditionName));
        $this->assertEquals($conditionName, $this->model->getConditionName());
    }
}
