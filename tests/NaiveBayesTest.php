<?php
// test/BasicTest.php

use wfphpnlp\NaiveBayes;

class NaiveBayesTest extends PHPUnit\Framework\TestCase
{

    public $result;
    public $hasil;

    public function setUp()
    {
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
        $nb->setClass(['positif', 'negatif', 'netral']);

        $nb->training($data);
        $this->result = $nb->predict('produknya buruk tidak keren');
        //print_r($this->result);
    }
    /** @test */
    public function testHasilKelas()
    {
        $kelas = "negatif";
        $this->assertEquals($kelas, $this->result['hasil']);
    }

    public function testHasilPositive()
    {
        $max_positive = 1.5625E-6;
        $this->assertEquals($max_positive, $this->result['positif']['result']);
    }

    public function testHasilNegative()
    {
        $max_negative = 3.5100024833268E-6;
        $this->assertEquals($max_negative, $this->result['negatif']['result']);
    }

    public function testHasilNetral()
    {
        $max_negative = 5.3357208905745E-7;
        $this->assertEquals($max_negative, $this->result['netral']['result']);
    }
}