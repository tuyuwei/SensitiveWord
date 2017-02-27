# SensitiveWord
 * 敏感词过滤类
 * 采用DFA算法
 装载后数据结构如下：
   $words = [
       '小' => [
           '日' => [
               '本' => false,
           ],
       ],
       '日' => [
          '本' => [
              '鬼' => [
                   '子' => false,
               ],
               '人' => false,
           ],
       ],
   ];
   
使用：
$data = [
    '小日本',
    '日本鬼子',
    '日本人',
];
$str = "日本人";

$wordObj = new SensitiveWord();
$wordObj->addSensitiveWord($data);


$txt = "你就是个日本人啊。。小日本。。。";
$words = $wordObj->search($txt);
print_r($words);
