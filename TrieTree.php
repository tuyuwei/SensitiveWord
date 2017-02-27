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
class TrieTree
{
    /**
     * 替换码
     * @var string
     */
    private $replaceCode;

    /**
     * 敏感词库
     * @var array
     */
    private $trieTreeMap = array();

    public function __construct($replaceCode = "*")
    {
        $this->replaceCode = $replaceCode;
    }

    /**
     * 添加敏感词
     * @param array $txtWords
     */
    public function addWords(array $wordsList)
    {
        foreach ($wordsList as $words) {
            $nowWords = &$this->trieTreeMap;
            $len = mb_strlen($words);
            for ($i = 0; $i < $len; $i++) {
                $word = mb_substr($words, $i, 1);
                if (!isset($nowWords[$word])) {
                    $nowWords[$word] = false;
                }
                $nowWords = &$nowWords[$word];
            }
        }
    }

    /**
     * 查找对应敏感词
     * @param $txt
     * @return array
     */
    public function search($txt)
    {
        $wordsList = array();
        $txtLength = mb_strlen($txt);
        for ($i = 0; $i < $txtLength; $i++) {
            $wordLength = $this->checkWord($txt, $i, $txtLength);
            if ($wordLength > 0) {
                $wordsList[] = mb_substr($txt, $i, $wordLength);//array($i, mb_substr($txt, $i, $wordLength));
                $i += $wordLength - 1;
            }
        }
        return $wordsList;
    }

    /**
     * 过滤敏感词
     * @param $txt
     * @return mixed
     */
    public function filter($txt)
    {
        $wordsList = $this->search($txt);
        if (empty($wordsList)) {
            return $txt;
        }
        foreach ($wordsList as $words) {
            $txt = str_replace($words, str_repeat($this->replaceCode, mb_strlen($words)), $txt);
        }
        return $txt;
    }

    /**
     * 敏感词检测
     * @param $txt
     * @param $beginIndex
     * @param $length
     * @return int
     */
    private function checkWord($txt, $beginIndex, $length)
    {
        $wordLength = 0;
        $trieTree = &$this->trieTreeMap;
        for ($i = $beginIndex; $i < $length; $i++) {
            $word = mb_substr($txt, $i, 1);
            if (!isset($trieTree[$word])) {
                break;
            }
            if ($trieTree[$word] !== false) {
                $trieTree = &$trieTree[$word];
            }
            $wordLength++;
        }
        return $wordLength;
    }
}



