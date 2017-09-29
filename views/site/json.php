<?php
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'file')->fileInput() ?>

    <button>Отправить</button>

<?php ActiveForm::end() ?>

<?php if ($data) : ?>

<?= Html::tag('h2', $data['title'], ['class' => 'table-title'])?>

<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider([
		'allModels' => $data['events']
	]),
	'tableOptions' => [
		'class' => 'table table-striped table-bordered main-table'
	],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'event',
        'date',
		'time_on',
		'type',
        [
            'class' => 'yii\grid\ActionColumn',
            'options' => [
				'width' => '130px',
			],
            'template' => '{shuffle}',
            'buttons' => [
                'shuffle' => function () {
                    return '<button class="shuffle-btn">Shuffle color</button>';
                },
            ],
        ],
    ],
	'rowOptions' => function($model) {
		if ($model['type'] > 0) {
			return ['style' => 'font-weight:bold;'];
		}
        if ($model['time_on'] > 0) {
            return ['style' => 'font-style:italic;'];
        }
        return false;
	}
]); ?>

    <?= Html::tag('button', 'Save table', ['class' => 'table-save-btn'])?>
    <?= Html::tag('button', 'Open list', ['class' => 'table-list-btn'])?>
	<div class="table-list">

	</div>
<?php endif; ?>
<?php $script = <<< JS
	function getRandomColor() {
	  var letters = '0123456789ABCDEF';
	  var color = '#';
	  for (var i = 0; i < 6; i++) {
		color += letters[Math.floor(Math.random() * 16)];
	  }
	  return color;
	}
	
    $('.shuffle-btn').click(function() {
      var row = $(this).closest('tr');
      var color = getRandomColor();
      row.attr('data-color', color);
      row.css('background-color', color);
    });

	var table = {};
	table.name = $('.table-title').html();
	
	$('.table-save-btn').click(function() {
	  var tableArr = [];
	  $('.main-table [data-key]').each(function() {
	    var row = {};
	    row.event = $(this).find('td:eq(1)').html();
	    row.date = $(this).find('td:eq(2)').html();
	    row.time_on = $(this).find('td:eq(3)').html();
	    row.type = $(this).find('td:eq(4)').html();
	    row.color = $(this).data('color');
	    tableArr.push(row);
	  });
	  table.json = JSON.stringify(tableArr);
	  $.ajax({
	  	type: 'POST',
	  	url: window.location.href,
	  	data: {action: 'save', name: table.name, json: table.json}
	  })
	    .done(function() {
    	  alert('Table saved!')
  		});
	});
	
	$('.table-list-btn').click(function() {
	  $.ajax({
	  	type: 'POST',
	  	url: window.location.href,
	  	data: {action: 'list'}
	  })
	    .done(function(html) {
	    	if (html != '') {
	    	  $('.table-list').css('border', '4px solid red');
    	      $('.table-list').html(html);
	    	}
  		});
	});
JS;

$this->registerJs($script, yii\web\View::POS_READY); ?>
