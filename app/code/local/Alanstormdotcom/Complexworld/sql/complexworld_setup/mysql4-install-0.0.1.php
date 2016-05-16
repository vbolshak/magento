<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 18.04.16
 * Time: 18:35
 */
$installer = $this;
$installer->addEntityType('complexworld_eavblogpost',Array(
//entity_mode is the URL you'd pass into a Mage::getModel() call
    'entity_model'          =>'complexworld/eavblogpost',
//blank for now
    'attribute_model'       =>'',
//table refers to the resource URI complexworld/eavblogpost
//<complexworld_resource_eav_mysql4>...<eavblogpost><table>eavblog_posts</table>
    'table'         =>'complexworld/eavblogpost',
//blank for now, but can also be eav/entity_increment_numeric
    'increment_model'       =>'',
//appears that this needs to be/can be above "1" if we're using eav/entity_increment_numeric
    'increment_per_store'   =>'0'
));

$installer->createEntityTables(
    $this->getTable('complexworld/eavblogpost')
);
//
//в этом месте обращаемся к классу  Alanstormdotcom_Complexworld_Entity_Setup конкретнок методу  public function getDefaultEntities()
//после выполнения этого действия в таблице eav_attribute  и eav_entity_attribute появится атрибут, которій мы определили
$installer->installEntities();
