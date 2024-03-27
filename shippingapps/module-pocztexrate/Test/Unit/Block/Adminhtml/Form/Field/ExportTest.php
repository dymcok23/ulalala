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
namespace ShippingApps\PocztexRate\Test\Unit\Block\Adminhtml\Form\Field;

use PHPUnit\Framework\TestCase;

class ExportTest extends TestCase
{
    /**
     * @var \ShippingApps\PocztexRate\Block\Adminhtml\Form\Field\Export
     */
    protected $_object;

    protected function setUp(): void
    {
        $backendUrl = $this->createMock(\Magento\Backend\Model\UrlInterface::class);
        $backendUrl->expects($this->once())->method('getUrl')->with("shqpocztexrate/system/exportPocztexrates", ['website' => 1]);

        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->_object = $objectManager->getObject(
            \ShippingApps\PocztexRate\Block\Adminhtml\Form\Field\Export::class,
            ['backendUrl' => $backendUrl]
        );
    }

    public function testGetElementHtml()
    {
        $expected = 'some test data';

        $form = $this->createPartialMock(\Magento\Framework\Data\Form::class, ['getParent']);
        $parentObjectMock = $this->createPartialMock(\Magento\Backend\Block\Template::class, ['getLayout']);
        $layoutMock = $this->createMock(\Magento\Framework\View\Layout::class);

        $blockMock = $this->createMock(\Magento\Backend\Block\Widget\Button::class);

        $requestMock = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $requestMock->expects($this->once())->method('getParam')->with('website')->will($this->returnValue(1));

        $mockData = $this->createPartialMock(\stdClass::class, ['toHtml']);
        $mockData->expects($this->once())->method('toHtml')->will($this->returnValue($expected));

        $blockMock->expects($this->once())->method('getRequest')->will($this->returnValue($requestMock));
        $blockMock->expects($this->any())->method('setData')->will($this->returnValue($mockData));

        $layoutMock->expects($this->once())->method('createBlock')->will($this->returnValue($blockMock));
        $parentObjectMock->expects($this->once())->method('getLayout')->will($this->returnValue($layoutMock));
        $form->expects($this->once())->method('getParent')->will($this->returnValue($parentObjectMock));

        $this->_object->setForm($form);
        $this->assertEquals($expected, $this->_object->getElementHtml());
    }
}
