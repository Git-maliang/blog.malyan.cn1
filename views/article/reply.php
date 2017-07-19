<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 17/7/19
 * Time: 上午10:38
 */
/* @var $id */
/* @var $comment \app\models\Comment */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

?>
<?php Pjax::begin(['id' => 'reply_country']) ?>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'reply-form',
        'data-pjax' => true,
        'class' => 'reply-form',
        'style' => 'display:none',
    ],
    'fieldConfig' => [
        'template' => '{input}'
    ],
]); ?>
<?= $form->field($comment, 'pid')->hiddenInput(); ?>
<?= $form->field($comment, 'uid')->hiddenInput(); ?>
<?= $form->field($comment, 'content')->textarea(['rows' => 3, 'maxlength' => 20]); ?>
<?php ActiveForm::end(); ?>
<?php Pjax::end() ?>
<?php
$js = <<<EOD
    $("document").ready(function(){ 
        $("#reply_country").on("pjax:end", function() {
            $.pjax.reload({container:"#countries"});
        });
    });
EOD;
$this->registerJs($js);
?>
