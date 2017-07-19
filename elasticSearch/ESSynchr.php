<?php

namespace app\elasticSearch;


use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * 增删改同步数据到ES
 * Class ESSynchr
 *
 * @package app\elasticSearch
 */
class ESSynchr extends Behavior
{

    /**
     * @var ActiveRecord $owner
     */
    public $owner;

    public function events()
    {
        return ArrayHelper::merge(parent::events(), [
            ActiveRecord::EVENT_AFTER_INSERT  => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'afterUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ]);
    }

    public function afterInsert($event)
    {
        $goodsSearch = new GoodsSearch();
        $data = $this->owner->attributes;
        foreach ($data as $field => $value) {
            $goodsSearch->$field = $value;
        }
        $goodsSearch->primaryKey = $data['id'];
        $goodsSearch->save();
    }

    public function afterUpdate($event)
    {
        $data = $this->owner->attributes;
        $goodsSearch = GoodsSearch::findOne($data['id']);

        /**
         * 更新做容错处理,如es中存在则更新,如不存在则新增
         */
        if (!empty($goodsSearch)) {
            foreach ($data as $field => $value) {
                $goodsSearch->$field = $value;
            }
        } else {
            $goodsSearch = new GoodsSearch();
            foreach ($data as $field => $value) {
                $goodsSearch->primaryKey = $data['id'];
                $goodsSearch->$field = $value;
            }
        }
        $goodsSearch->save();
    }

    public function beforeDelete($event)
    {
        $data = $this->owner->attributes;
        $goodsSearch = GoodsSearch::findOne($data['id']);

        if (!empty($goodsSearch)) {
            $goodsSearch->delete();
        }
    }
}