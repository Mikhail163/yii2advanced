<?php namespace frontend\tests;

/**
 * 
 * 3) Перейти в консоле в папку фронтэнда и создайте класс юнит тестов, реализовав в нем проверки с помощью перечисленных методов, тест должен проходить успешно
    - $this->assertTrue - сравнении с true
    - $this->assertEquals - равно ожидаемому значению
    - $this->assertLessThan - меньше ожидаемого значения
    - $this->assertAttributeEquals - значение атрибута (свойства) объекта равно ожидаемому значению - создайте экземпляр ContactForm, заполните аттрибуты и проверьте, можно так тестировать, например массовую загрузку значений атрибутов.
    - $this->assertArrayHasKey - в массиве есть указанный ключ
 *
 */
class EduTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $test_array = ['first' => 1, 'second' => 2];
        $test_obj = (object) $test_array;
        
        $this->assertTrue($test_obj->{'first'} != $test_obj->{'second'});
        $this->assertEquals(1, $test_obj->{'first'});
        $this->assertLessThan( $test_obj->{'second'}, $test_obj->{'first'});      
        $this->assertAttributeEquals('1', 'first', $test_obj);
        $this->assertArrayHasKey('first', $test_array);
        
        expect($test_array)->hasKey('first');
    }
}