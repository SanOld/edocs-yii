<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class EdocsAsset extends AssetBundle
{
    public $basePath = '@webroot/web/';
    public $baseUrl = '@web/web/';
    public $css = [
                'css/bootstrap.css'
                ,"https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"
//                ,"css/font-awesome.css"
                ,"dhtmlxSuite_v50_std/skins/web/dhtmlx.css"
                ,"css/helper.css"
                ,"css/style.css"
    ];
    public $js = [
                "dhtmlxSuite_v50_std/codebase/ext/swfobject.js"     
//                ,"js/lib/jquery-latest.js"
                ,"js/lib/jquery-ui-latest.js"
                ,"js/lib/bootstrap.min.js"
                ,"dhtmlxSuite_v50_std/codebase/dhtmlx.js"
                ,"js/lib/dhtmlxPartsPro/dhtmlxInsertDeleteColumn.js"
                ,"js/include.js"
                ,"js/edocs.js"
                ,"js/init.js"
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

