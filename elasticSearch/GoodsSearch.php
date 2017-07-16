<?php

namespace app\elasticSearch;


use yii\elasticsearch\ActiveRecord;

class GoodsSearch extends ActiveRecord
{

    public function attributes()
    {
        return [
            'id',
            'goods_name',
            'goods_desc',
            'cid',
            'goods_num',
            'goods_price',
            'goods_img',
            'goods_pics',
            'is_promote',
            'promote_price',
            'is_hot',
            'promote_price',
            'is_hot',
            'ison',
            'istui',
            'created_at',
            'updated_at',
        ];
    }

    public static function index()
    {
        return 'yiishop';
    }

    public static function type()
    {
        return 'goods';
    }

}