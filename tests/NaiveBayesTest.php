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
                'text' => 'Filmnya bagus, saya suka',
                'class' => 'positif'
            ],
            [
                'text' => 'Film jelek, aktingnya payah.',
                'class' => 'negatif'
            ],
        ];
        $nb = new NaiveBayes();
        $nb->setClass(['positif', 'negatif']);

        $nb->training($data);
        $this->result = $nb->predict('alur ceritanya jelek dan aktingnya payah');
    }
    /** @test */
    public function testHasilKelas()
    {
        $kelas = "negatif";
        $this->assertEquals($kelas, $this->result['hasil']);
    }

    public function testHasilMaxPositive()
    {
        $max_positive = 0.0005787037037037;
        $this->assertEquals($max_positive, $this->result['positif']['result']);
    }

    public function testHasilMaxNegative()
    {
        $max_negative = 0.0046296296296296;
        $this->assertEquals($max_negative, $this->result['negatif']['result']);
    }
}