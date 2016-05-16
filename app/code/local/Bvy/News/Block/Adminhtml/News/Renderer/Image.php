<?php

// в этом файле пишем получение картинки для вывода тхамбнейла.
class Bvy_News_Block_Adminhtml_News_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $html = '<img ';
        $html .= 'id="' . $this->getColumn()->getId() . '" ';
        $html .= 'width="' . $this->getColumn()->getWidth() . '" ';
        $d = $this->getColumn()->getIndex();
        $b= $row->getData($d );
        $html .= 'src="' . Mage::getBaseUrl("media") .  $row->getData($this->getColumn()->getIndex()) . '"';
        $html .= 'class="grid-image ' . $this->getColumn()->getInlineCss() . '"/>';
        return $html;
    }
}
?>