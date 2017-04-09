<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world'){
        echo \Yii::getVersion();
        echo $message . "\n";


    }

    public function actionA($arr1=[],$arr2=[])
    {

        $arr1 = [2,3,6];
        $arr2 = [1,3,5];
        $arr = array_merge($arr1,$arr2);
        $length = count($arr);

        for($i = 0; $i<$length; $i++){
            for($j=0; $j<$length-1-$i; $j++){
                if($arr[$j] > $arr[$j+1]){
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j+1];
                    $arr[$j+1] = $temp;
                }
            }
        }

        print_r($arr);








    }

}
