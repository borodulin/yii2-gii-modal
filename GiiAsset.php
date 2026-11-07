<?php
/**
 * @link https://github.com/borodulin/yii2-gii-modal
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-gii-modal/blob/master/LICENSE
 */

namespace conquer\gii;

use yii\web\AssetBundle;

/**
 * Client script of the generated modal CRUD.
 *
 * Bootstrap is registered by the generated `Modal` widget (and by your layout), so this bundle
 * works with Bootstrap 3, 4 and 5. yii.js is required: it follows the `X-Redirect` sent after
 * a successful AJAX save and prevents scripts already on the page from being loaded again.
 *
 * @author Andrey Borodulin
 */
class GiiAsset extends AssetBundle
{
    public $sourcePath = '@conquer/gii/assets';

    public $js = [
        'gii-modal.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];
}
