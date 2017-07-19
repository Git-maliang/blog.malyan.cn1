<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 17/7/19
 * Time: 上午10:38
 */
/* @var $comment \app\models\Comment */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

?>
<?php Pjax::begin(['id' => 'comment_country']) ?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true
    ],
    'fieldConfig' => ['template' => '{input}'],
]); ?>
<?= $form->field($comment, 'content')->textarea(['rows' => 5, 'maxlength' => 20]); ?>
<?= Html::submitButton('评论', ['class' => 'btn btn-default']) ?>
<?php ActiveForm::end(); ?>
<?php Pjax::end() ?>
<?php
$js = <<<EOD
    $("document").ready(function(){ 
        $("#comment_country").on("pjax:end", function() {
            $.pjax.reload({container:"#countries"});
        });
    });
EOD;
$this->registerJs($js);
?>
