<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator conquer\gii\templates\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$baseModelName = StringHelper::basename($generator->modelClass);
$wordsModelName = Inflector::camel2words($baseModelName);
$idModelName =  Inflector::camel2id($baseModelName);
$title = $generator->generateString(Inflector::pluralize($wordsModelName));
$singular = $generator->generateString($wordsModelName);

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use <?= $generator->getBootstrapNamespace() ?>\Modal;
<?php if ($generator->indexWidgetType === 'grid'): ?>
use conquer\gii\ModalActionColumn;
<?php endif; ?>
use conquer\gii\GiiAsset;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

GiiAsset::register($this);

$this->title = <?= $title ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= $idModelName ?>-index">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

    <p>
    <?= "<?= " ?>Html::a(<?= $dataHeader = $generator->generateString('Create ' . $wordsModelName) ?>, ['create'], [
        'class' => 'btn btn-success show-modal',
        'data-target' => '#modal_view',
        'data-header' => <?= $dataHeader ?>,
    ]); ?>
    </p>

    <?= "<?= " ?>Modal::widget([
        'id' => 'modal_view',
<?php if ($generator->bsVersion == 3): ?>
        'header' => '<h4 class="modal-title"></h4>',
<?php else: ?>
        'title' => '',
<?php endif; ?>
    ]); ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

            [
                'class' => ModalActionColumn::class,
                'modalTarget' => '#modal_view',
                'modalHeaders' => [
                    'view' => Yii::t('yii', 'View') . ' ' . <?= $singular ?>,
                    'update' => Yii::t('yii', 'Update') . ' ' . <?= $singular ?>,
                ],
            ],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>], [
                'class' => 'show-modal',
                'data-target' => '#modal_view',
                'data-header' => Yii::t('yii', 'View') . ' ' . <?= $singular ?>,
            ]);
        },
    ]) ?>
<?php endif; ?>

</div>
