<?php


class TemplateTest extends \PHPUnit_Framework_TestCase
{

    public function test_construnctor_withNoParams_returnsProperInstace()
    {
        $tpl = new \H4D\Template\Template();
        $this->assertTrue($tpl instanceof \H4D\Template\Template);
    }

    public function test_create_withProperParam_returnsTemplateInstance()
    {
        $tpl = \H4D\Template\Template::create(__DIR__ . '/tpls/simple.txt');
        $this->assertTrue($tpl instanceof \H4D\Template\Template);
    }

    /**
     * @expectedException \H4D\Template\Exceptions\FileNotFoundException
     */
    public function test_render_withBadFile_throwsException()
    {
        $tpl = new \H4D\Template\Template();
        $tpl->render(__DIR__.'/noFile.txt');
    }

    public function test_render_withProperParams_returnsString()
    {
        $tpl = new \H4D\Template\Template();
        $tpl->addVar('name', 'WORLD');
        $rendered = $tpl->render(__DIR__ . '/tpls/simple.txt');
        $this->assertTrue(is_string($rendered));
    }

    public function test_render_withProperParams_returnsProperString()
    {
        $tpl = new \H4D\Template\Template();
        $tpl->addVar('name', 'WORLD');
        $rendered = $tpl->render(__DIR__ . '/tpls/simple.txt');
        $this->assertEquals('Hello WORLD!', $rendered);
    }

    public function test_setTemplateFile()
    {
        $tpl = new \H4D\Template\Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $this->assertEquals(__DIR__ . '/tpls/simple.txt', $tpl->getTemplateFile());
    }

    public function test_hasTemplateFile()
    {
        $tpl = new \H4D\Template\Template();
        $this->assertFalse($tpl->hasTemplateFileDefined());
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $this->assertTrue($tpl->hasTemplateFileDefined());
    }

    public function test_toString_withProperParams_returnsProperString()
    {
        $tpl = new \H4D\Template\Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $tpl->addVar('name', 'WORLD');
        $rendered = $tpl->__toString();
        $this->assertEquals('Hello WORLD!', $rendered);
    }

    public function test_toString_withBadParams_returnsString()
    {
        $tpl = new \H4D\Template\Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/noFile.txt');
        $rendered = $tpl->__toString();
        $this->assertTrue(is_string($rendered));
    }

    /**
     * @expectedException \H4D\Template\Exceptions\RequiredOptionMissedException
     */
    public function test_construnctor_withNoParamsWhenRequiredOptions_throwsException()
    {
        new MyTemplate();
    }

    public function test_construnctor_withRequiredOptions_returnsProperInstace()
    {
        $tpl = new MyTemplate(['requiredOption-01'=>'A', 'requiredOption-02'=>'B']);
        $this->assertTrue($tpl instanceof \H4D\Template\Template);
    }

    public function test_varsMethods()
    {
        $tpl = new \H4D\Template\Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $vars = ['a'=>'A', 'b'=>'B'];
        foreach ($vars as $k=>$v)
        {
            $tpl->addVar($k, $v);
        }
        $tplVars = $tpl->getTemplateVars();
        $this->assertEquals($vars, $tplVars);

        $tplVars = $tpl->getVars();
        $this->assertEquals($vars, $tplVars);

        $vars = ['c'=>true, 'd'=>0];
        $tpl->setTemplateVars($vars);
        $tplVars = $tpl->getVars();
        $this->assertEquals($vars, $tplVars);

        $vars = ['c'=>1, 'd'=>false];
        $tpl->setVars($vars);
        $tplVars = $tpl->getVars();
        $this->assertEquals($vars, $tplVars);

        $vars = ['e'=>'E'];
        $tpl->addTemplateVars($vars);
        $this->assertEquals(['c'=>1, 'd'=>false, 'e'=>'E'], $tpl->getVars());

        $vars = ['f'=>'F'];
        $tpl->addVars($vars);
        $this->assertEquals(['c'=>1, 'd'=>false, 'e'=>'E', 'f'=>'F'], $tpl->getVars());

    }

}