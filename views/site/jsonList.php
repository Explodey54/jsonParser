<?php
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
?>

<?php foreach ($list as $item): ?>

    <?= Html::tag('h2', $item['name'])?>

    <?= Html::tag('h3', $item['timestamp'])?>

    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => json_decode($item['json'], true)
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'event',
            'date',
            'time_on',
            'type',
        ],
        'rowOptions' => function($model) {
            $style = '';
            if ($model['type'] > 0) {
                $style = $style.'font-weight:bold;';
            }
            if ($model['time_on'] > 0) {
                $style = $style.'font-style:italic;';
            }
            if ($model['color']) {
                $style = $style.'background-color:'.$model['color'];
            }
            return ['style' => $style];
        }
    ]); ?>

<?php endforeach; ?>
