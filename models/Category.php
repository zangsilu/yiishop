<?php
/**
 * User: 张世路
 * Date: 2016/10/5
 * Time: 22:26
 */

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Category extends ActiveRecord{

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return "{{%category}}";
    }

    public function attributeLabels()
    {
        return [
          'pid' => '所属分类',
            'title'=>'分类名称'
        ];
    }

    public function rules()
    {
        return [
            ['pid','required','message'=>'所属分类不能为空!'],
            ['title','required','message'=>'分类名称不能为空!'],
            ['created_at','safe'],
        ];
    }


    public function add($data){

        $data['Category']['created_at'] = time();
        if($this->load($data) && $this->save()){
            return true;
        }
        return false;
    }


    /* 获取分类数据 */
    protected function getData()
    {
        $data = $this->find()->asArray()->all();
        return $data;
    }

    /* 获取分类树 */
    protected function getTree(&$list,$pid=0,$level=1,$html='--------'){
        static $tree = array();
        foreach($list as $v){
            if($v['pid'] == $pid){
                $v['sort'] = $level;
                $v['title'] = str_repeat($html,$level).$v['title'];
                $tree[] = $v;
                $this->getTree($list,$v['id'],$level+1);
            }
        }
        return $tree;
    }

    /* 获取分类下拉列表显示数据 */
    public function getOption()
    {
        $data = $this->getData();
        $data = $this->getTree($data);

        $options[0] = '顶级分类';
        foreach($data as $k =>$v){
            $options[$v['id']] = $v['title'];
        }
        return $options;
    }






}