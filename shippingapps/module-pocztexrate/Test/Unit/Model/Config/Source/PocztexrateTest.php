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
namespace ShippingApps\PocztexRate\Test\Unit\Model\Config\Source;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use PHPUnit\Framework\TestCase;

class PocztexrateTest extends TestCase
{
    /**
     * @var \ShippingApps\PocztexRate\Model\Config\Source\Pocztexrate
     */
    protected $model;

    /**
     * @var \ShippingApps\PocztexRate\Model\Carrier\Pocztexrate|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $carrierPocztexrateMock;

    /** @var ObjectManagerHelper */
    protected $objectManagerHelper;

    protected function setUp(): void
    {
        $this->carrierPocztexrateMock = $this->getMockBuilder('\ShippingApps\PocztexRate\Model\Carrier\Pocztexrate')
            ->disableOriginalConstructor()
            ->setMethods(['getCode'])
            ->getMock();

        $this->objectManagerHelper = new ObjectManagerHelper($this);

        $this->model = $this->objectManagerHelper->getObject('ShippingApps\PocztexRate\Model\Config\Source\Pocztexrate', [
            'carrierPocztexrate' => $this->carrierPocztexrateMock
        ]);
    }

    public function testToOptionArray()
    {
        $codes = [1, 2, 3, 4, 5];
        $expected = [];
        foreach ($codes as $k => $v) {
            $expected[] = ['value' => $k, 'label' => $v];
        }

        $this->carrierPocztexrateMock->expects($this->once())
            ->method('getCode')
            ->willReturn($codes);

        $this->assertEquals($expected, $this->model->toOptionArray());
    }
}
