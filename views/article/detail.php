<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 17/5/12
 * Time: 下午3:12
 */
/* @var $article \app\models\Article */
/* @var $reply \app\models\form\CommentForm */
/* @var $comment \app\models\Comment */
/* @var $userDynamic \app\models\UserDynamic */
/* @var $comments */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Markdown;
use yii\widgets\Pjax;

$this->title = $article->title;
$this->params['breadcrumbs'] = [
    ['label' => '文章', 'url' => ['article/index']],
    $article->title
];
?>
<div  id='wx_pic'  style="margin:0 auto;display:none;">
    <img src="/images/pic300.jpg">
</div>
<div class="row">
    <div class="col-sm-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- 标题 -->
                <div class="page-header">
                    <h1>
                        <?= Html::encode($article->title); ?>
                        <small>[ <?= $article->categoryArray[$article->category]; ?> ]</small>
                    </h1>
                </div>
                <div class="action">
                    <!-- 作者 -->
                    <span>
                        <a href="/user/42068">
                            <i class="fa fa-user"></i>
                            <?= Html::encode($userDynamic->user->nickname); ?>
                        </a>
                    </span>
                    <!-- 时间 -->
                    <span>
                        <i class="fa fa-clock-o"></i>
                        <?= date('Y-m-d H:i:s', $userDynamic->created_at); ?>
                    </span>
                    <!-- 浏览次数 -->
                    <span>
                        <i class="fa fa-eye"></i>
                        <?= $article->browse_num; ?>次浏览
                    </span>
                    <!-- 评论次数 -->
                    <span>
                        <a href="#comments">
                            <i class="fa fa-comments-o"></i>
                            <?= $article->comment_num; ?>条评论
                        </a>
                    </span>
                    <!-- 收藏次数 -->
                    <span>
                        <a class="favorite" href="javascript:void(0);" title="" data-type="post" data-id="1265" data-toggle="tooltip" data-original-title="收藏">
                            <i class="fa fa-star-o"></i>
                            <?= $article->collect_num; ?>
                        </a>
                    </span>
                    <span class="pull-right">
                        <!-- 顶次数 -->
                        <a class="vote up" href="javascript:void(0);" title="" data-type="post" data-id="1265" data-toggle="tooltip" data-original-title="顶">
                            <i class="fa fa-thumbs-o-up"></i>
                            <?= $article->praise_num; ?>
                        </a>
                        <!-- 踩次数 -->
                        <a class="vote down" href="javascript:void(0);" title="" data-type="post" data-id="1265" data-toggle="tooltip" data-original-title="踩">
                            <i class="fa fa-thumbs-o-down"></i>
                            <?= $article->tread_num; ?>
                        </a>
                    </span>
                </div>
                <!-- 文章内容 -->
                <?= Markdown::process($article->content, 'gfm-comment'); ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="comments">
                    <?php Pjax::begin(['id' => 'countries']); ?>
                    <div class="page-header">
                        <?= Html::tag('h2','共 <em>' . count($comments) . '</em> 条评论'); ?>
                        <!--
                        Nav::widget([
                            'options' => ['class' => 'nav nav-tabs nav-sub'],
                            'items' => [
                                ['label' => '默认排序' ,'url' => '/sort', 'link', 'active' => true],
                                ['label' => '最后评论' ,'url' => '/desc', 'active' => false],
                            ]
                        ]);
                        -->
                    </div>
                    <?php if($comments): ?>
                        <ul class="media-list">
                        <?php foreach ($comments as $val): ?>
                            <li class="media">
                                <div class="media-left">
                                    <a href="javascript:void(0)" rel="author">
                                        <img class="media-object" src="<?= Html::encode($val['dynamic']['user']['avatar']); ?>" alt="wushshsha">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <a href="javascript:void(0)" rel="author"><?= Html::encode($val['dynamic']['user']['nickname']); ?></a>
                                        评论于 <?= date('Y-m-d H:i:s', $val['dynamic']['created_at']); ?>
                                    </div>
                                    <div class="media-content">
                                        <p><?= Html::encode($val['content']); ?></p>
                                        <?php if(isset($val['child'])): ?>
                                            <div class="hint">
                                                共
                                                <em><?= count($val['child']); ?></em>
                                                条回复
                                            </div>
                                            <?php foreach ($val['child'] as $v): ?>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0)" rel="author">
                                                            <img class="media-object" src="<?= Html::encode($v['dynamic']['user']['avatar']); ?>" alt="iceluo">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="media-heading">
                                                            <a href="javascript:void(0)" rel="author"><?= Html::encode($v['dynamic']['user']['nickname']); ?></a>
                                                            评论于 <?= date('Y-m-d H:i:s', $v['dynamic']['created_at']); ?>

                                                            <?php if(Yii::$app->user->id != $v['dynamic']['user_id']): ?>
                                                            <span class="pull-right">
                                                                <a class="reply" href="javascript:void(0);" data-uid="<?= $v['dynamic']['user_id']; ?>" data-pid="<?= $val['id']; ?>" data-nickname="<?= Html::encode($v['dynamic']['user']['nickname']); ?>">
                                                                    <i class="fa fa-reply"></i>
                                                                    回复
                                                                </a>
                                                            </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="media-content">
                                                            <p><?= $v['uid'] ? Html::a('@'. $val['user'][$v['uid']]['nickname'], 'javascript:void(0)') . ' ' : ''; ?><?= Html::encode($v['content']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <div class="media-action">
                                        <a class="reply" href="javascript:void(0);" data-uid="0" data-pid="<?= $val['id']; ?>" data-nickname="<?= Html::encode($val['dynamic']['user']['nickname']); ?>">
                                            <i class="fa fa-reply"></i>
                                            回复
                                        </a>
                                        <div class="reply-box" style="display: none">
                                            <div class="form-group field-comment-content required">
                                                <textarea class="form-control" maxlength="20" rows="3" aria-required="true"></textarea>
                                            </div>
                                            <button type="button" class="btn btn-default reply-button">评论</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        暂无评论
                    <?php endif; ?>
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- 评论区 -->
                <div id="comment">
                    <div class="page-header">
                        <h2>发表评论</h2>
                    </div>
                    <?php if(Yii::$app->user->isGuest): ?>
                    <div class="well danger">
                            您需要登录后才可以评论。
                            <?= Html::a('登录', 'javascript:void(0)', [
                                'data-title' => '登录',
                                'data-url' => '/user/login',
                                'data-toggle' => 'modal',
                                'data-target' => '#page-modal',
                                'class' => 'page-modal',
                            ]); ?>
                            |
                            <?= Html::a('注册', 'javascript:void(0)'); ?>
                    </div>
                     <?php else: ?>
                        <?= $this->render('comment', [
                            'comment' => $comment,
                        ]); ?>
                        <?= $this->render('reply', [
                            'comment' => $comment,
                        ]); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->render('right-content'); ?>
</div>
<?php
if(!Yii::$app->user->isGuest){

    $uidId = Html::getInputId($comment, 'uid');
    $pidId = Html::getInputId($comment, 'pid');
    $contentId = Html::getInputId($comment, 'content');
    $js = <<<EOD
    $(document).on("click", ".reply",  function() {
        var replyBox = $(this).parents(".media-content").find(".reply-box");
        var form = $("#reply-form");
        form.find("#{$uidId}").val($(this).data("uid"));
        form.find("#{$pidId}").val($(this).data("pid"));
        replyBox.find("textarea").attr("placeholder", "@"+$(this).data("nickname")).val("");
        $(".reply-box").hide();
        replyBox.show();
    });
    
    $(document).on("blur", ".reply-box textarea", function() {
		var content = $(this).val();
		if(content.length <=2 ){
			$(this).parent().addClass("has-error");
		}else{
			$(this).parent().removeClass("has-error");
		}
	});
	
	$(document).on("click", ".reply-button", function(){
	    var textarea = $(this).siblings('div').find('textarea');
	    var content = textarea.val();
	    if(content.length <=2 ){
			textarea.parent().addClass("has-error");
			return false;
		}else{
			textarea.parent().removeClass("has-error");
		}
		
		form = $("#reply-form").find("#{$contentId}").val(content);
		form.submit();
	});
EOD;
    $this->registerJs($js);
}
?>
