<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 19.03.16
 * Time: 17:04
 */

class Magentotutorial_Weblog_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction(){
        echo "setup";
    }

    public function testModelAction() {
        $params = $this->getRequest()->getParams();
        $blogpost = Mage::getModel('weblog/test_blogpost');   //название модели, вторая часть путь:тест папка, файл blogpost
        echo("Loading the blogpost with an ID of ".$params['id']);
        $blogpost->load($params['id']);
       $a=  $blogpost->title;
        $data = $blogpost->getData();
        $a=  $blogpost->load($params['id'])->getPost();
        $a=$blogpost->load($params['id'])->setPost('aaaaaaaaaaaaaaaaaaaaaaaa');
        $blogpost->save();
        $newMod = Mage::getModel('weblog/test_blogpost')->addData(['title'=>'adde from php']);
        $newMod->save();
        $col = Mage::getModel('weblog/test_blogpost')->getCollection();
        foreach ($col as $entite) {
            echo $entite->title;

        }

        var_dump($data);
    }


}