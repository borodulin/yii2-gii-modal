<?php
/**
 * @link https://github.com/borodulin/yii2-gii-modal
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-gii-modal/blob/master/LICENSE
 */

namespace conquer\gii\templates\crud;

/**
 * CRUD generator whose views open view/create/update pages in a Bootstrap modal.
 *
 * @author Andrey Borodulin
 */
class Generator extends \yii\gii\generators\crud\Generator
{
    /**
     * @var array Bootstrap major version => [Yii extension namespace, composer package]
     */
    public static $bootstrapExtensions = [
        5 => ['yii\bootstrap5', 'yiisoft/yii2-bootstrap5'],
        4 => ['yii\bootstrap4', 'yiisoft/yii2-bootstrap4'],
        3 => ['yii\bootstrap', 'yiisoft/yii2-bootstrap'],
    ];

    /**
     * @var int|null Bootstrap major version (3, 4 or 5) used by the generated code.
     * Defaults to the newest installed Yii Bootstrap extension.
     */
    public $bsVersion;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->bsVersion === null) {
            $this->bsVersion = static::detectBsVersion();
        }
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Modal CRUD Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a controller and views that implement CRUD operations '
            . 'with the view, create and update pages opened in a Bootstrap modal.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['bsVersion', 'validateBsVersion', 'skipOnEmpty' => false],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'bsVersion' => 'Bootstrap Version',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'bsVersion' => 'Bootstrap version of your application. The matching Yii extension '
                . '(<code>yiisoft/yii2-bootstrap</code>, <code>yii2-bootstrap4</code> or <code>yii2-bootstrap5</code>) must be installed.',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['bsVersion']);
    }

    /**
     * Validates [[bsVersion]] and checks that the matching Yii Bootstrap extension is installed.
     */
    public function validateBsVersion()
    {
        if ($this->bsVersion === null || $this->bsVersion === '') {
            $this->addError('bsVersion', 'No Yii Bootstrap extension found. Install one of: '
                . implode(', ', array_column(static::$bootstrapExtensions, 1)) . '.');
            return;
        }
        if (!is_numeric($this->bsVersion) || !isset(static::$bootstrapExtensions[(int)$this->bsVersion])) {
            $this->addError('bsVersion', 'Bootstrap Version must be 3, 4 or 5.');
            return;
        }
        $this->bsVersion = (int)$this->bsVersion;
        if (!class_exists($this->getBootstrapNamespace() . '\Modal')) {
            $this->addError('bsVersion', 'Bootstrap ' . $this->bsVersion . ' requires the '
                . static::$bootstrapExtensions[$this->bsVersion][1] . ' extension: composer require '
                . static::$bootstrapExtensions[$this->bsVersion][1]);
        }
    }

    /**
     * @return string namespace of the Yii Bootstrap extension for [[bsVersion]], e.g. `yii\bootstrap5`
     */
    public function getBootstrapNamespace()
    {
        return static::$bootstrapExtensions[(int)$this->bsVersion][0];
    }

    /**
     * @return int|null the newest Bootstrap version whose Yii extension is installed
     */
    public static function detectBsVersion()
    {
        foreach (static::$bootstrapExtensions as $version => $extension) {
            if (class_exists($extension[0] . '\Modal')) {
                return $version;
            }
        }
        return null;
    }
}
