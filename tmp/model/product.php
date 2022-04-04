<?php
global $app;
helper::cd($app->getBasePath());
helper::import('module/product/model.php');
helper::cd();
class extproductModel extends productModel 
{
public function setMenu($products, $productID, $branch = 0, $module = 0, $moduleType = '', $extra = '')
{
    return $this->loadExtension('web')->setMenu($products, $productID, $branch, $module, $moduleType, $extra);
}
//**//
}