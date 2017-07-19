<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $aid
 * @property integer $uid
 * @property string $content
 */
class Comment extends \yii\db\ActiveRecord
{
    public $message;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['pid', 'aid', 'uid'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '评论ID',
            'aid' => '文章ID',
            'uid' => '用户ID',
            'content' => '内容',
        ];
    }

    public function getDynamic()
    {
        return $this->hasOne(UserDynamic::className(), ['id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    public function getChild()
    {
        return $this->hasMany(self::className(), ['pid' => 'id']);
    }

    public function getComments($id)
    {
        $comments = self::find()->innerJoinWith(['dynamic' => function(ActiveQuery $query){
            $query->innerJoinWith(['user' => function(ActiveQuery $query){
                $query->select(['id', 'nickname', 'avatar']);
            }]);
        }])->where(['aid' => $id])->indexBy('id')->asArray()->all();
        foreach ($comments as $comment){
            if($comment['pid']){
                $comments[$comment['pid']]['child'][] = $comment;
                $comments[$comment['pid']]['user'][$comment['dynamic']['user']['id']] = $comment['dynamic']['user'];
                unset($comments[$comment['id']]);
            }
        }
        return $comments;
    }
}
