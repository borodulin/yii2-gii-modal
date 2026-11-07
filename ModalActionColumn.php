<?php
/**
 * @link https://github.com/borodulin/yii2-gii-modal
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-gii-modal/blob/master/LICENSE
 */

namespace conquer\gii;

use Yii;
use yii\grid\ActionColumn;

/**
 * Action column whose default buttons (view and update by default) open their page in a modal.
 * Icons, titles and other options of the default buttons are kept.
 *
 * ```php
 * [
 *     'class' => ModalActionColumn::class,
 *     'modalTarget' => '#modal_view',
 *     'modalHeaders' => ['view' => 'View Post', 'update' => 'Update Post'],
 * ]
 * ```
 *
 * @author Andrey Borodulin
 */
class ModalActionColumn extends ActionColumn
{
    /**
     * @var string jQuery selector of the modal the pages are loaded into
     */
    public $modalTarget = '#modal_view';

    /**
     * @var string[] names of the default buttons that open in the modal
     */
    public $modalButtons = ['view', 'update'];

    /**
     * @var array button name => modal header text (plain text). Defaults to the button title.
     */
    public $modalHeaders = [];

    /**
     * @inheritdoc
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (in_array($name, $this->modalButtons, true)) {
            $additionalOptions = array_merge([
                'class' => 'show-modal',
                'data-target' => $this->modalTarget,
                'data-header' => isset($this->modalHeaders[$name])
                    ? $this->modalHeaders[$name]
                    : Yii::t('yii', ucfirst($name)),
            ], $additionalOptions);
        }
        parent::initDefaultButton($name, $iconName, $additionalOptions);
    }
}
