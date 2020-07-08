# Naive Bayes Classifier

[![Build Status](https://travis-ci.org/WillyFaq/Naive-Bayes-Classifier.svg?branch=master)](https://travis-ci.org/github/WillyFaq/Naive-Bayes-Classifier)
[![GitHub](https://img.shields.io/github/license/willyfaq/Naive-Bayes-Classifier)](https://github.com/WillyFaq/Naive-Bayes-Classifier/blob/master/LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/wfphpnlp/naivebayesclassifier)](https://packagist.org/packages/wfphpnlp/naivebayesclassifier#dev-master)

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
use wfphpnlp\NaiveBayes;
```
Berikut contoh lengkap penggunaan.
```php
<?php
    // include composer autoloader
    require_once __DIR__ . '/vendor/autoload.php';
    use wfphpnlp\NaiveBayes;

    $data = [
                [
                    'text' => 'produknya keren kualitasnya bagus awet dan tahan lama',
                    'class' => 'positif'
                ],
                [
                    'text' => 'barangnya bagus mudah digunakan',
                    'class' => 'positif'
                ],
                [
                    'text' => 'barangnya cepat rusak kualitas buruk, tidak bisa digunakan sama sekali',
                    'class' => 'negatif'
                ],
                [
                    'text' => 'produknya jelek tidak sesuai harapan',
                    'class' => 'negatif'
                ],
                [
                    'text' => 'produk sudah cukup baik, cara penggunaanya juga cukup mudah',
                    'class' => 'netral'
                ],
            ];
			
    $nb = new NaiveBayes();
    // mendefinisikan class target sesuai dengan yang ada pada data training.
    $nb->setClass(['positif', 'negatif', 'netral']);

    // proses training
    $nb->training($data);

    // pengujian
    $result = $nb->predict('produknya buruk tidak keren'); // output "negatif"
    
    print_r($result);
/*
    
    //hasil output
    Array
    (
        [positif] => Array
            (
                [computed] => Array
                    (
                        [0] => 0.038461538461538
                        [1] => 0.019230769230769
                        [2] => 0.019230769230769
                        [3] => 0.038461538461538
                    )

                [result] => 0.023076923076923
            )

        [negatif] => Array
            (
                [computed] => Array
                    (
                        [0] => 0.037037037037037
                        [1] => 0.037037037037037
                        [2] => 0.055555555555556
                        [3] => 0.018518518518519
                    )

                [result] => 0.02962962962963
            )

        [netral] => Array
            (
                [computed] => Array
                    (
                        [0] => 0.021739130434783
                        [1] => 0.021739130434783
                        [2] => 0.021739130434783
                        [3] => 0.021739130434783
                    )

                [result] => 0.017391304347826
            )

        [hasil] => negatif
    )
*/
```
