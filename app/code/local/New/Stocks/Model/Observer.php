<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Observer
 *
 * @author denis
 */
class New_Stocks_Model_Observer
{
    /**
     * Append the previously top topmenu added links to the menu collection
     */
    public function blockTopmenu ( Varien_Event_Observer $observer ) {
        $event = $observer->getEvent();

        $menu = $event->getMenu();
        $tree = $menu->getTree();
        $data = array(
                'id'            => 'promo-top-link',
                'name'          => Mage::helper('stocks')->__('Stocks'),
                'url'           => Mage::getUrl('stocks/index/list'),
        );
        $node = new Varien_Data_Tree_Node( $data, 'id', $tree, $menu);
        $menu->addChild( $node );        
    }
}