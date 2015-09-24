<?php
/**
* CakePHP Smarty view class
* @package      smartyview
* @subpackage   view
* @since        CakePHP v 3.0
* @license      MIT License
*/
# app/src/View/SmartyView.php
namespace App\View;
use Cake\View\View;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\Network\Response;
# installed via composer @ bootstrap.php
# require_once(ROOT . '/vendor' . DS . 'autoload.php');
use \Smarty;
use \SmartyBC;

/**
* CakePHP Smarty view class
*
* This class will allow using Smarty with CakePHP
*
* @package      smartyview
* @subpackage   view
* @since        CakePHP v 3.0
*/
class SmartyView extends View
{
    protected $_ext = '.tpl';
    protected $_smarty = null;
    
    public function __construct(Request $request = null, Response $response = null, EventManager $eventManager = null, array $viewOptions = [])
    {
        
        $this->_smarty = new SmartyBC();
        
        //tmp dir
        $use_dir     = TMP . 'smarty' . DS;
        $compile_dir = $use_dir . 'compile' .DS;
        $cache_dir   = $use_dir . 'cache' . DS;
        
        !file_exists($use_dir) && mkdir($use_dir);
        !file_exists($compile_dir) && mkdir($compile_dir);
        !file_exists($cache_dir) && mkdir($cache_dir);
        
        $this->_smarty->compile_dir     = $compile_dir;
        $this->_smarty->cache_dir       = $cache_dir;
        
        //configs & plugins
        $configs_dir = [App::path('View')[0] . 'Smarty' . DS . 'Configs'];
        $plugins_dir = [App::path('View')[0] . 'Smarty' . DS . 'Plugins'];
        
        $this->_smarty->addConfigDir($configs_dir);
        $this->_smarty->addPluginsDir($plugins_dir);
        
        //smarty setting
        foreach (Configure::read('Smarty') as $key => $value) {
            $this->_smarty->{$key} = $value;
        }
        
        parent::__construct($request, $response, $eventManager, $viewOptions);
    }
    
    protected function _evaluate($viewFile, $dataForView)
    {
        foreach ($dataForView as $key => $val) {
            $this->_smarty->assign($key, $val);
        }
        $this->_smarty->assignByRef('this', $this);
        
        return $this->_smarty->fetch($viewFile);
    }
}
