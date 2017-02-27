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

$trieTree = new TrieTree();
$trieTree->addWords($data);

$txt = "日本人.不是.大中华。。。";

$words = $trieTree->search($txt);
print_r($words);

$txt = $trieTree->filter($txt);
echo $txt, "\n";
print_r($words);
