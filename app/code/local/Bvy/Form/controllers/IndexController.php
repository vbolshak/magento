<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 18.03.16
 * Time: 13:22
 */



class Bvy_Form_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction()
    {


        $this->loadLayout();
//       $this->getLayout()->createBlock('bvy_form/form');
        $this->renderLayout();

    }

    public function sendemailAction()
    {
        //Fetch submited params
        $params = $this->getRequest()->getParams();

        $mail = new Zend_Mail();
        $mail->setBodyText($params['comment']);
        $mail->setFrom($params['email'], $params['name']);
        $mail->addTo('somebody_else@example.com', 'Some Recipient');
        $mail->setSubject('Test Inchoo_SimpleContact Module for Magento');
        try {
            $mail->send();
        }
        catch(Exception $ex) {
            Mage::getSingleton('core/session')->addError('Unable to send email. Sample of a custom notification error from vetal.');

        }

        //Redirect back to index action of (this) inchoo-simplecontact controller
        $this->_redirect('form/');
    }


    public function sendajaxAction()
    {
        //Fetch submited params
        $params = $this->getRequest()->getParams();
        $data = array('com' => $params['comment'],
                     'name' => $params['email'],
                     'text' => 'from php');

        echo json_encode($data);
    }


}