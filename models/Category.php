<?php
/**
 * User: 张世路
 * Date: 2016/10/5
 * Time: 22:26
 */

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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


    public function add($data)
    {

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

    /* 获取分类树(精简版) */
    protected function getTree2(&$list,$pid=0){
        static $tree = array();
        foreach($list as $v){
            if($v['pid'] == $pid){
                $tree[] = $v['id'];
                $this->getTree2($list,$v['id']);
            }
        }
        return $tree;
    }


    /**获取所有子分类及其自身
     * @param $id
     * @return array
     */
    public function getSubIds($id)
    {
        $info = $this->find()->all();
        $list = $this->getTree2($info,$id);
        $list =  ArrayHelper::toArray($list);
        return $list;
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

    /**
     * 获取分类菜单
     */
    public static function getMenu()
    {
        $cate = self::find()->where(['pid'=>0])->asArray()->all();
        foreach($cate as $k=>$v){
            $cate[$k]['child'] = self::find()->where(['pid'=>$v['id']])->asArray()->all();
        }
        return $cate;
    }

    /**
     * 获取分类列表,用于js_tree插件
     */
    public static function getCategoryTreeList()
    {
        $data = self::find()->where(['pid'=>0]);
        if(empty($data)){
            return [];
        }
        $pager = new Pagination(['totalCount'=>$data->count(),'pageSize'=>10]);
        $data = $data->orderBy('created_at desc')->offset($pager->offset)->limit($data->limit)->all();

        $list = [];
        foreach ($data as $k=>$v){
            $list[] = [
                'id'=>$v->id,
                'text'=>$v->title,
                'children'=>self::getChild($v->id),
            ];
        }
        return ['data'=>$list,'pager'=>$pager];
    }

    public static function getChild($id)
    {
        $data = self::find()->where(['pid'=>$id])->all();

        $children = [];
        if(!empty($data)){
            foreach ($data as $k=>$v){
                $children[]=[
                    'id' =>$v->id,
                    'text'=>$v->title,
                    'children' => self::getChild($v->id),
                ];
            }
        }
        return $children;
    }





}