<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 15/02/2020
 * Time: 20:55
 */

namespace Tests\Framework;


use Framework\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{


    public function testRequireIfFail()
    {
        $errors = $this->makeValidator([
            'name' => 'joe'
        ])
            ->required('name', 'content')
            ->getErrors();

        $this->assertCount(1, $errors);

    }

    public function testNoEmpty()
    {
        $errors = $this->makeValidator([
            'name' => 'joe',
            'content' => '',
        ])
            ->notEmpty('content')
            ->getErrors();

        $this->assertCount(1, $errors);

    }

    public function testRequireIfSuccess()
    {
        $errors = $this->makeValidator([
            'name' => 'joe',
            'content' => 'content',
        ])
            ->required('name', 'content')
            ->getErrors();

        $this->assertCount(0, $errors);
    }

    public function testSlugSuccess()
    {
        $errors = $this->makeValidator([
            'slug' => 'aze-aze-ae-az-51-ada4',
        ])
            ->slug('slug')
            ->getErrors();

        $this->assertCount(0, $errors);
    }

    public function testSlugError()
    {
        $errors = $this->makeValidator([
            'slug' => 'aze-aze-ae_az-51-ada4',
            'slug2' => 'aze-aze-ae-Az-51-ada4',
            'slug3' => 'aze--aze-ae-az-51-ada4',
        ])
            ->slug('slug')
            ->slug('slug2')
            ->slug('slug3')
            ->slug('slug4')
            ->getErrors();

        $this->assertCount(3, $errors);
    }

    public function testLength()
    {
        $params = [
            'slug' => '123456789',
        ];
        $this->assertCount(0, $this->makeValidator($params)->length('slug', 3)->getErrors());
        $errors = $this->makeValidator($params)->length('slug', 12)->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals('Le champs slug doit contenir plus de 12 caractères', (string)$errors['slug']);
        $this->assertCount(1, $this->makeValidator($params)->length('slug', 3, 4)->getErrors());
        $this->assertCount(0, $this->makeValidator($params)->length('slug', 3, 20)->getErrors());
        $this->assertCount(0, $this->makeValidator($params)->length('slug', null, 20)->getErrors());
        $this->assertCount(1, $this->makeValidator($params)->length('slug', null, 8)->getErrors());
    }

    public function testDatetime()
    {
        $this->assertCount(0, $this->makeValidator(['date' => '2012-12-12 11:12:13'])->dateTime('date')->getErrors());
        $this->assertCount(0, $this->makeValidator(['date' => '2012-12-12 00:00:00'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2012-22-12'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2013-02-29'])->dateTime('date')->getErrors());

    }

    private function makeValidator(array $params): Validator
    {
        return new Validator($params);
    }

}