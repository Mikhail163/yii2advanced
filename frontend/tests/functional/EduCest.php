<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class EduCest
{
    public function _before(FunctionalTester $I)
    {
    }

    /**
     * @param @dataProvider pageProvider
     */
    public function tryToTest(FunctionalTester $I, \Codeception\Example $data)
    {
        $I->amOnPage($data['url']);
        $I->see($data['h1'], 'h1');
    }
    
    protected function pageProvider()
    {
        return [
            ['url'=>'site/about', 'h1'=>'About'],
            ['url'=>'site/contact', 'h1'=>'Contact'],
            ['url'=>'site/signup', 'h1'=>'Signup'],
        ];
    }
}
