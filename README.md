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
    $this->result = $nb->predict('produknya buruk tidak keren'); // output "negatif"
    
    print_r($p);
/*
    
    //hasil output
    Array
    (
        [positif] => Array
            (
                [computed] => Array
                    (
                        [0] => 0.05
                        [1] => 0.025
                        [2] => 0.025
                        [3] => 0.05
                    )

                [result] => 1.5625E-6
            )

        [negatif] => Array
            (
                [computed] => Array
                    (
                        [0] => 0.046511627906977
                        [1] => 0.046511627906977
                        [2] => 0.069767441860465
                        [3] => 0.023255813953488
                    )

                [result] => 3.5100024833268E-6
            )

        [netral] => Array
            (
                [computed] => Array
                    (
                        [0] => 0.027027027027027
                        [1] => 0.027027027027027
                        [2] => 0.027027027027027
                        [3] => 0.027027027027027
                    )

                [result] => 5.3357208905745E-7
            )

        [hasil] => negatif
    )
*/
```
