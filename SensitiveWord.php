<?php

/**
 * Class SensitiveWord
 * @author: tywei
 * @email: usertyw@gmail.com
 * @date: 2017/02/27
 * @description:
 * 敏感词过滤类
 * 采用DFA算法
 * 装载后数据结构如下：
 *   $words = [
 *       '小' => [
 *           '日' => [
 *               '本' => false,
 *           ],
 *       ],
 *       '日' => [
 *          '本' => [
 *              '鬼' => [
 *                   '子' => false,
 *               ],
 *               '人' => false,
 *           ],
 *       ],
 *   ];
 */
class SensitiveWord
{
    public $sensitiveWords = array();

    public function addSensitiveWord(array $txtWords)
    {
        foreach ($txtWords as $words) {
           $nowWords = &$this->sensitiveWords;
           $len = mb_strlen($words);
           for ($i=0; $i < $len; $i++) {
               $word = mb_substr($words, $i, 1);
               if (!isset($nowWords[$word])) {
                   $nowWords[$word] = false;
               }
               $nowWords = &$nowWords[$word];
           }
        }
    }

    public function search($txt)
    {
        $words = array();
        $sensitiveWords = &$this->sensitiveWords;
        $len = mb_strlen($txt);
        $scoreWord = '';
        for ($i=0; $i < $len; $i++) {
            $word = mb_substr($txt, $i, 1);
            if (isset($sensitiveWords[$word])) {
                $scoreWord .= $word;
                if ($sensitiveWords[$word] === false) {
                    $words[] = $scoreWord;
                    $scoreWord = '';
                    $sensitiveWords = &$this->sensitiveWords;
                } else {
                    $sensitiveWords = &$sensitiveWords[$word];
                }
            }
        }
        return $words;
    }
}





