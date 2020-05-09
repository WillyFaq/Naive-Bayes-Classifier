# Naive Bayes Classifier

[![Build Status](https://travis-ci.org/WillyFaq/Naive-Bayes-Classifier.svg?branch=master)](https://travis-ci.org/github/WillyFaq/Naive-Bayes-Classifier)
[![GitHub](https://img.shields.io/github/license/willyfaq/Naive-Bayes-Classifier)]()
[![Packagist Version](https://img.shields.io/packagist/v/willyfaq/Naive-Bayes-Classifier)](https://packagist.org/packages/wfphpnlp/naivebayesclassifier#dev-master)

Library PHP untuk klasifikasi teks menjadi klasifikasi positif, negatif dan netral pada Bahasa Indonesia menggunakan metode Naive Bayes Classifier.

## Cara Install
### Via Composer
```bash
composer require wfphpnlp/naivebayesclassifier
```
Jika Anda masih belum memahami bagaimana cara menggunakan Composer, silahkan baca [Getting Started with Composer](https://getcomposer.org/doc/00-intro.md).
### Clone GitHub
```bash
git clone https://github.com/WillyFaq/Naive-Bayes-Classifier.git
```
## Cara Penggunaan
jika menggunakan composer inisiasikan projek anda dengan `vendor/autoload.php`
```php
require_once __DIR__ . '/vendor/autoload.php';
use wfphpnlp/NaiveBayes;
```
Berikut contoh lengkap penggunaan.
```php
<?php
// include composer autoloader
require_once __DIR__ . '/vendor/autoload.php';
use wfphpnlp/NaiveBayes;

    $data = [
        [
            'text' => 'Filmnya bagus, saya suka',
            'class' => 'positif'
        ],
        [
            'text' => 'Film jelek, aktingnya payah.',
            'class' => 'negatif'
        ],
    ];
			
    $nb = new NaiveBayes();
    // mendefinisikan class target sesuai dengan yang ada pada data training.
    $nb->setClass(['positif', 'negatif']);

    // proses training
    $nb->training($data);

    // pengujian
    $p =  $nb->predict('alur ceritanya jelek dan aktingnya payah'); // output "negatif"
    
    print_r($p);
/*
Array
(
    [positif] => Array
        (
            [computed] => Array
                (
                    [0] => 0.083333333333333
                    [1] => 0.083333333333333
                    [2] => 0.083333333333333
                )

            [result] => 0.0005787037037037
        )

    [negatif] => Array
        (
            [computed] => Array
                (
                    [0] => 0.16666666666667
                    [1] => 0.16666666666667
                    [2] => 0.16666666666667
                )

            [result] => 0.0046296296296296
        )

    [hasil] => negatif
)
*/
```
