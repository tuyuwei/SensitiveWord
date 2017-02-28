#敏感词过滤类
采用DFA算法

装载后数据结构如下：
 ```php
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
 ```   
使用：

```php
    $disturbList = ['&', '*'];
    $data = ['日本册', '日本人', '大中华'];
    
    $wordObj = new TrieTree($disturbList);
    $wordObj->addWords($data);
    
    $txt = "日本加.不是.大中&华。。。";
    
    $words = $wordObj->search($txt);
    print_r($words);
    
    $txt = $wordObj->filter($txt);
    echo $txt, "\n";
```
输出：

```console
Array
(
    [0] => 大中&华
)
日本加.不是.****。。。
```
