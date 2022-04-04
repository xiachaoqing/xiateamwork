<?php
/**
 * The control file of qa module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     qa
 * @version     $Id: control.php 4129 2013-01-18 01:58:14Z wwccss $
*/
class qa extends control
{
    /**
     * The index of qa, go to bug's browse page.
     * 
     * @access public
     * @return void
     */
    public function index($locate = 'auto', $productID = 0)
    {
        $this->products = $this->loadModel('product')->getPairs('nocode');
        if(empty($this->products)) die($this->locate($this->createLink('product', 'showErrorNone', "fromModule=qa")));
        if($locate == 'yes') $this->locate($this->createLink('bug', 'browse'));

        if($this->app->viewType != 'mhtml') unset($this->lang->qa->menu->index);
        $productID = $this->product->saveState($productID, $this->products);
        $branch    = (int)$this->cookie->preBranch;
        $this->qa->setMenu($this->products, $productID, $branch);

        $this->view->title      = $this->lang->qa->index;
        $this->view->position[] = $this->lang->qa->index;
        $this->view->products   = $this->products;
        $this->display();
    }
}
