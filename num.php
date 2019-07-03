<?php
/**
 * Created by PhpStorm.
 * User: micoing
 * Date: 3/07/19
 * Time: 10:37 PM
 */


/**
 * @param float $num  概率 0 ~ 100  不能是0
 * @param int $bit 小数精确位数
 * @return float
 */
function prize($num, $bit = 3){

    $base = 100;
    //获取随即区间
    $i = [];
    for ($ss = 0; $ss < floor($base / $num) ; $ss++ ){
        $i[] = $ss * $num;
    }
    $interval_pick = array_rand($i);

    $pro = pow(10, $bit);
    $intervalMultiple = $pro / $base; //使基数和 bit相符合
    $interval = [$i[$interval_pick] * $intervalMultiple, ($i[$interval_pick] + $num)  * $intervalMultiple];
    $rand = mt_rand(1, $pro);
//    echo $interval_pick ;
//    echo json_encode($interval);
//    echo $rand ."\n";
    if(($interval[0]) < $rand && $rand < ($interval[1]))
        return true;

    return false;
}



function go(){
    $pro = 15;  //中奖概率 当前 15%
    $num = 10000; //总次数
    $offSet = 4; //偏移量
    $z = 0;
    for ($i=0; $i < $num; $i ++){
        if(prize($pro))
            $z++;
    }

    echo $num . "\n";
    echo $z . "\n";

    echo "######################\n";

    /*
    比如预设的中奖率是 10% ,   然后实际发出1000个  中奖150个 =  15%  就把当前的中奖率往下调调
    中奖率 = 10%
    [中奖率] - (max(150 / 1000 * 100, 10) - [中奖率])   // 加入max目的是实际中间率过小不增加预设中奖率, 希望极可能少中奖，哈哈哈哈
    = 本轮实际中奖率是5%

     */
    $autoZ = 0;
    for ($i=0; $i < $num; $i ++){
        $tPro = $pro - (max(($autoZ / $num * 100) + $offSet, $pro) - $pro);
//    echo 'tPro:'.$autoZ / $num * 100 . "\n";
//    echo 'tPro:'.$tPro . "\n";
        if(prize($tPro))
            $autoZ++;
    }
    echo $num . "\n";
    echo $autoZ . "\n";

    echo "End######################\n";
    echo "\n";
    echo "\n";
}


for ($i=0; $i < 10; $i ++){
    go();
}
