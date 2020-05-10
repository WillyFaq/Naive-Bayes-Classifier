<?php
/*
 * (c) WillyFaq <willyfaqurokhim@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

// If you don't to add a custom vendor folder, then use the simple class
// namespace wfphpnlp;

namespace wfphpnlp;


class NaiveBayes
{
    /**
     * Data class or target.
     *
     * @var array
     */
    public $class;

    /**
     * Data training.
     * 
     * @var array
     */
    public $data;

    /**
     * Stemmed data training.
     * 
     * @var array
     */
    public $stemmedData;

    /**
     * All words.
     *
     * @var array
     */
    public $words;

    /**
     * Group of words each class or target.
     *
     * @var array
     */
    public $wordsClass;

    /**
     * Set available class or target.
     * 
     * @param array $class
     * @return void
     */
    public function setClass($class)
    {
        $this->class = $class;
        $this->setWordsClass($class);
    }

    /**
     * Set words and computing data for each class.
     *
     * @param string $class
     * @return void
     */
    protected function setWordsClass($class)
    {
        $this->wordsClass = [];
        foreach ($class as $item) {
            $this->wordsClass[] = [
                'class' => $item,
                'words' => [],
                'pData' => 0,
                'computed' => []
            ];
        }
    }

    /**
     * Filter data by class or target.
     *
     * @param string $class
     * @return array
     */
    public function getDataByClass($class)
    {
        return array_filter($this->data, function ($item) use ($class) {
            return ($item['class'] === $class);
        });
    }

    /**
     * Set stemmed data.
     *
     * @param array $data
     * @return void
     */
    public function setStemmedData($data)
    {
        $this->stemmedData = $data;
    }

    /**
     * Set stemmed words.
     *
     * @param array $words
     * @return void
     */
    public function setWords($words)
    {
        $this->words = $words;
    }

    /**
     * Find wordsClass index by class.
     *
     * @param string $class
     * @return int
     */
    public function findWordsClassIndex($class)
    {
        foreach ($this->wordsClass as $index => $item) {
            foreach ($item as $key => $value) {
                if ($item['class'] === $class) {
                    return $index;
                }
            }
        }

        return -1;
    }

    /**
     * Training data.
     *
     * @param array $data
     * @return void
     */
    public function training($data)
    {
        $this->data = $data;
        
        $sw = [];
        foreach ($this->data as $index => $item) {  
            $x = explode(" ", $item['text']);
            $tmp = [];
            foreach ($x as $a => $b) {
                $sw[] = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $b));
                $tmp[] = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $b));
            }
            $this->data[$index]['text'] = join(" ",$tmp);
        }

        $unique = array_unique($sw);
        $sw = array_values($unique);

        $this->setWords($sw);

        foreach ($this->class as $item) {
            $classData = $this->getDataByClass($item);
            $index = $this->findWordsClassIndex($item);

            foreach ($this->words as $word) {
                $this->wordsClass[$index]['words'][] = ['word' => $word, 'count' => 0];
            }

            foreach ($classData as $item) {
                $splits = explode(' ', $item['text']);
                foreach ($this->wordsClass[$index]['words'] as $key => $word) {
                    foreach ($splits as $split) {
                        if ($word['word'] === $split) {
                            $this->wordsClass[$index]['words'][$key]['count']++;
                        }
                    }
                }
            }

            $this->wordsClass[$index]['pData'] = count($classData) / count($data);
            $wordsCount = count(array_filter($this->wordsClass[$index]['words'], function ($item) {
                return ($item['count'] !== 0);
            }));
            foreach ($this->wordsClass[$index]['words'] as $word) {
                $this->wordsClass[$index]['computed'][] = [
                    'word' => $word['word'],
                    'value' => ($word['count'] + 1) / ($wordsCount + count($this->words))
                ];
            }
        }
    }

    /**
     * Predict data.
     *
     * @param string|array $data
     * @return string
     */
    public function predict($data)
    {
        $wordsArray = explode(' ', $data);

        // calculate each class
        $testClass = [];
        foreach ($this->class as $class) {
            $index = $this->findWordsClassIndex($class);
            foreach ($wordsArray as $word) {
                $match = array_filter($this->wordsClass[$index]['computed'], function ($item) use ($word) {
                    return ($item['word'] === $word);
                });

                if ($match) {
                    $testClass[$class]['computed'][] = reset($match)['value'];
                }
            }

            $testClass[$class]['result'] = 1; // init the result for the class
        }

        foreach ($testClass as $key => $value) {
            foreach ($value['computed'] as $val) {
                $testClass[$key]['result'] *= $val;
            }
        }

        $result = [];
        foreach ($this->class as $class) {
            $result[] = $testClass[$class]['result'];
        }

        $max = max($result);
        $k = '';
        foreach ($testClass as $key => $item) {
            if ($item['result'] === $max) $k = $key;
        }
        $testClass['hasil'] = $k;
        return $testClass;
    }
}