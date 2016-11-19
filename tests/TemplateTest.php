<?php

namespace H4D\Template\Tests\Unit;

use H4D\Template\Template;

class TemplateTest extends \PHPUnit_Framework_TestCase
{
    use PrivateAccessTrait;

    public function test_construnctor_withNoOptions_returnsProperInstace()
    {
        $tpl = new Template();
        $this->assertTrue($tpl instanceof Template);
        $this->assertEquals([], $this->getNonPublicPropertyValue($tpl, 'constructorOptions'));
    }

    public function test_constructor_withOptions_returnsProperInstance()
    {
        $options = ['A' => 'B', 'C' => 'D'];
        $tpl = new Template($options);
        $this->assertTrue($tpl instanceof Template);
        $this->assertEquals($options, $this->getNonPublicPropertyValue($tpl, 'constructorOptions'));
    }

    /**
     * @expectedException \H4D\Template\Exceptions\RequiredOptionMissedException
     */
    public function test_construnctor_withNoOptionsWhenRequiredOptions_throwsException()
    {
        new MyTemplateWithRequiredOptions();
    }

    /**
     * @expectedException \H4D\Template\Exceptions\RequiredOptionMissedException
     */
    public function test_construnctor_withMissingRequiredOptionsWhenRequiredOptions_throwsException()
    {
        new MyTemplateWithRequiredOptions(['requiredOption-01' => 'A', 'option' => 'B']);
    }

    public function test_construnctor_withRequiredOptions_returnsProperInstace()
    {
        $tpl = new MyTemplateWithRequiredOptions(['requiredOption-01' => 'A',
                                                  'requiredOption-02' => 'B']);
        $this->assertTrue($tpl instanceof Template);
    }

    public function test_create_withProperParam_returnsTemplateInstance()
    {
        $tpl = Template::create(__DIR__ . '/tpls/simple.txt');
        $this->assertTrue($tpl instanceof Template);
    }

    /**
     * @expectedException \H4D\Template\Exceptions\FileNotFoundException
     */
    public function test_render_withNonExistingFileAsTemplate_throwsException()
    {
        $tpl = new Template();
        $tpl->render(__DIR__ . '/noFile.txt');
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     */
    public function test_render_withProperParams_returnsString()
    {
        $tpl = new Template();
        $tpl->addVar('name', 'WORLD');
        $rendered = $tpl->render(__DIR__ . '/tpls/simple.txt');
        $this->assertTrue(is_string($rendered));
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     */
    public function test_render_withProperParams_returnsProperString()
    {
        $tpl = new Template();
        $tpl->addVar('name', 'WORLD');
        $rendered = $tpl->render(__DIR__ . '/tpls/simple.txt');
        $this->assertEquals('Hello WORLD!', $rendered);
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     */
    public function test_setTemplateFile_setsTemplateFileProperly()
    {
        $tpl = new Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $this->assertEquals(__DIR__ . '/tpls/simple.txt',
                            $this->getNonPublicPropertyValue($tpl, 'templateFile'));
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     * @depends test_setTemplateFile_setsTemplateFileProperly
     */
    public function test_hasTemplateFile()
    {
        $tpl = new Template();
        $this->assertFalse($tpl->hasTemplateFileDefined());
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $this->assertTrue($tpl->hasTemplateFileDefined());
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     * @depends test_setTemplateFile_setsTemplateFileProperly
     */
    public function test_addVar_addsVarsProperly()
    {
        $tpl = new Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $tpl->addVar('var1', 'val1');
        $this->assertEquals(['var1' => 'val1'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));
        $tpl->addVar('var2', 'val2');
        $this->assertEquals(['var1' => 'val1', 'var2' => 'val2'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     * @depends test_setTemplateFile_setsTemplateFileProperly
     */
    public function test_addTemplateVar_addsVarsProperly()
    {
        $tpl = new Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $tpl->addTemplateVar('var1', 'val1');
        $this->assertEquals(['var1' => 'val1'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));
        $tpl->addTemplateVar('var2', 'val2');
        $this->assertEquals(['var1' => 'val1', 'var2' => 'val2'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     * @depends test_setTemplateFile_setsTemplateFileProperly
     */
    public function test_addVars_addsVarsProperly()
    {
        $tpl = new Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $tpl->addVars(['var1' => 'val1']);
        $this->assertEquals(['var1' => 'val1'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));
        $tpl->addVars(['var2' => 'val2', 'var3' => 'val3']);
        $this->assertEquals(['var1' => 'val1', 'var2' => 'val2', 'var3' => 'val3'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));

    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     * @depends test_setTemplateFile_setsTemplateFileProperly
     */
    public function test_addTemplateVars_addsVarsProperly()
    {
        $tpl = new Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $tpl->addTemplateVars(['var1' => 'val1']);
        $this->assertEquals(['var1' => 'val1'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));
        $tpl->addTemplateVars(['var2' => 'val2', 'var3' => 'val3']);
        $this->assertEquals(['var1' => 'val1', 'var2' => 'val2', 'var3' => 'val3'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));

    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     * @depends test_setTemplateFile_setsTemplateFileProperly
     */
    public function test_setVars_setsVarsProperly()
    {
        $tpl = new Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $tpl->addVar('delete', 'val');
        $tpl->setVars(['var1' => 'val1']);
        $this->assertEquals(['var1' => 'val1'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));
        $tpl->setVars(['var2' => 'val2', 'var3' => 'val3']);
        $this->assertEquals(['var2' => 'val2', 'var3' => 'val3'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     * @depends test_setTemplateFile_setsTemplateFileProperly
     */
    public function test_setTemplateVars_setsVarsProperly()
    {
        $tpl = new Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $tpl->addVar('delete', 'val');
        $tpl->setTemplateVars(['var1' => 'val1']);
        $this->assertEquals(['var1' => 'val1'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));
        $tpl->setTemplateVars(['var2' => 'val2', 'var3' => 'val3']);
        $this->assertEquals(['var2' => 'val2', 'var3' => 'val3'],
                            $this->getNonPublicPropertyValue($tpl, 'templateVars'));
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     * @depends test_setTemplateFile_setsTemplateFileProperly
     * @depends test_addVar_addsVarsProperly
     */
    public function test_toString_withProperParams_returnsProperString()
    {
        $tpl = new Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $tpl->addVar('name', 'WORLD');
        $rendered = $tpl->__toString();
        $this->assertEquals('Hello WORLD!', $rendered);
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     */
    public function test_toString_withBadParams_returnsString()
    {
        $tpl = new Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/noFile.txt');
        $rendered = $tpl->__toString();
        $this->assertTrue(is_string($rendered));
    }

    /**
     * @depends test_construnctor_withNoOptions_returnsProperInstace
     * @depends test_setTemplateFile_setsTemplateFileProperly
     * @depends test_addTemplateVar_addsVarsProperly
     * @depends test_addVar_addsVarsProperly
     * @depends test_setVars_setsVarsProperly
     * @depends test_setTemplateVars_setsVarsProperly
     */
    public function test_getterMethods()
    {
        $tpl = new Template();
        $tpl->setTemplateFile(__DIR__ . '/tpls/simple.txt');
        $vars = ['a' => 'A', 'b' => 'B'];
        foreach ($vars as $k => $v)
        {
            $tpl->addVar($k, $v);
        }
        $tplVars = $tpl->getTemplateVars();
        $this->assertEquals($vars, $tplVars);

        $tplVars = $tpl->getVars();
        $this->assertEquals($vars, $tplVars);

        $vars = ['c' => true, 'd' => 0];
        $tpl->setTemplateVars($vars);
        $tplVars = $tpl->getVars();
        $this->assertEquals($vars, $tplVars);

        $vars = ['c' => 1, 'd' => false];
        $tpl->setVars($vars);
        $tplVars = $tpl->getVars();
        $this->assertEquals($vars, $tplVars);

        $vars = ['e' => 'E'];
        $tpl->addTemplateVars($vars);
        $this->assertEquals(['c' => 1, 'd' => false, 'e' => 'E'], $tpl->getVars());

        $vars = ['f' => 'F'];
        $tpl->addVars($vars);
        $this->assertEquals(['c' => 1, 'd' => false, 'e' => 'E', 'f' => 'F'], $tpl->getVars());

    }

}