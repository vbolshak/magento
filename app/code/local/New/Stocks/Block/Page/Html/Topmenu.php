<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Topmenu
 *
 * @author denis
 */
class New_Stocks_Block_Page_Html_Topmenu extends Mage_Page_Block_Html_Topmenu
{
    /**
     * Stores the added links
     */
    protected $additionalLinks = array();



    /**
     * Add a new link to the topmenu block
     *
     * Currently only the type 'path' is supported
     *
     * @param string $label
     * @param string $type
     * @param string $value
     */
    public function addLink( $label, $type, $value ) {
            if ( 'path' == $type ) {
                    $_coreUrlHelper = $this->helper( 'core/url' );

                    $currentPath = str_replace( Mage::getBaseUrl(), '', $_coreUrlHelper->getCurrentUrl() );

                    $url = Mage::getUrl( $value );

                    $data = array(
                            'label'                 => $label,
                            'url'                   => $url,
                            'is_active'             => (int)( $value == $currentPath ),
                    );

                    $this->additionalLinks[ $url ] = $data;
            }
    }



    /**
     * Get list of added links
     *
     * @return array
     */
    public function getAdditionalLinks() {
            return $this->additionalLinks;
    }
}
