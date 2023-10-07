<?php

use Christophedlr\Phpfilewriter\Phpfilewriter;
use PHPUnit\Framework\TestCase;

final class PhpfilewirterTest extends TestCase
{
    /**
     * @var Phpfilewriter
     */
    private $phpfilewriter;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->phpfilewriter = new Phpfilewriter();
    }


    /**
     * Test insert a start PHP tag
     *
     * @return void
     * @throws Exception
     */
    public function testStartInsertTag(): void
    {
        $this->phpfilewriter->insertTag();

        $this->assertEquals('<?php', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert a end PHP tag
     *
     * @return void
     * @throws Exception
     */
    public function testEndInsertTag(): void
    {
        $this->phpfilewriter->insertTag($this->phpfilewriter::END_TAG);

        $this->assertEquals('?>', $this->phpfilewriter->getCode());
    }

    /**
     * Test return exception if invalid insert tag
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionInsertTag(): void
    {
        $this->expectException(Exception::class);

        $this->phpfilewriter->insertTag(10);
    }

    /**
     * Test insert a new line
     *
     * @return void
     * @throws Exception
     */
    public function testInsertNl(): void
    {
        $this->phpfilewriter->insertNl();

        $this->assertEquals(PHP_EOL, $this->phpfilewriter->getCode());
    }

    /**
     * Test insert multiple new line
     *
     * @return void
     * @throws Exception
     */
    public function testInsertXNl(): void
    {
        $this->phpfilewriter->insertNl(2);

        $this->assertEquals(PHP_EOL . PHP_EOL, $this->phpfilewriter->getCode());
    }

    /**
     * Test return exception if invalid insert new line
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionInsertNl(): void
    {
        $this->expectException(Exception::class);

        $this->phpfilewriter->insertNl(0);
    }

    /**
     * Test insert a classic indentation (4 spaces)
     *
     * @return void
     */
    public function testDefaultInsertIdentation(): void
    {
        $this->phpfilewriter->insertIndentation();

        $this->assertEquals('    ', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert one indentation with 8 spaces
     *
     * @return void
     */
    public function testInsertIndentation(): void
    {
        $this->phpfilewriter->insertIndentation(1, 8);

        $this->assertEquals('        ', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert 4 indentations with default size (4 spaces)
     *
     * @return void
     */
    public function testXInsertIndentation(): void
    {
        $this->phpfilewriter->insertIndentation(4, 4);

        $this->assertEquals('                ', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert single use instruction
     *
     * @return void
     */
    public function testInsertUse(): void
    {
        $this->phpfilewriter->insertUse('Exception');

        $this->assertEquals('use Exception;', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert use instruction with an alias
     *
     * @return void
     */
    public function testInsertUseWithAlias(): void
    {
        $this->phpfilewriter->insertUse('My\\Full\\Classname', 'Another');

        $this->assertEquals('use My\\Full\\Classname as Another;', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert namespace instruction
     *
     * @return void
     */
    public function testInsertNamespace(): void
    {
        $this->phpfilewriter->insertNamespace('My\\Namespace');

        $this->assertEquals('namespace My\\Namespace;', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert class instruction
     *
     * @return void
     * @throws Exception
     */
    public function testSimpleInsertClass(): void
    {
        $this->phpfilewriter->insertClass('MyClass');

        $this->assertEquals('class MyClass', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert class instruction with abstract type of class
     *
     * @return void
     * @throws Exception
     */
    public function testInsertClassWithAbstractType(): void
    {
        $this->phpfilewriter->insertClass('MyClass', $this->phpfilewriter::TYPE_ABSTRACT);

        $this->assertEquals('abstract class MyClass', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert interface instruction
     *
     * @return void
     * @throws Exception
     */
    public function testInsertClassWithInterfaceType(): void
    {
        $this->phpfilewriter->insertClass('MyInterface', $this->phpfilewriter::TYPE_INTERFACE);

        $this->assertEquals('interface MyInterface', $this->phpfilewriter->getCode());
    }

    /**
     * Test return Exception if bad type value of insertClass
     *
     * @return void
     * @throws Exception
     */
    public function testInsertClassWithBadTypeValue(): void
    {
        $this->expectException(Exception::class);

        $this->phpfilewriter->insertClass('GoodClassWithBadType', 'test');
    }

    /**
     * Test insert class with extends instruction
     *
     * @throws Exception
     */
    public function testInsertClassWithExtends(): void
    {
        $this->phpfilewriter->insertClass('MyClass', '', 'Extended\\Class');

        $this->assertEquals('class MyClass extends Extended\\Class', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert abstract class with extends instruction
     *
     * @throws Exception
     */
    public function testInsertClassWithAbstractTypeAndExtends(): void
    {
        $this->phpfilewriter->insertClass('MyAbstractClass', $this->phpfilewriter::TYPE_ABSTRACT, 'Extended\\Class');

        $this->assertEquals('abstract class MyAbstractClass extends Extended\\Class', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert simple class with implements instruction
     *
     * @return void
     * @throws Exception
     */
    public function testInsertClassWithImplements(): void
    {
        $this->phpfilewriter->insertClass('MyClass', '', '', 'MyInterface');

        $this->assertEquals('class MyClass implements MyInterface', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert simple class with extends and implements instructions
     *
     * @throws Exception
     */
    public function testInsertClassWithExtendsAndImplements(): void
    {
        $this->phpfilewriter->insertClass('MyClass', '', 'MyAbstractClass', 'MyInterface');

        $this->assertEquals(
            'class MyClass extends MyAbstractClass implements MyInterface',
            $this->phpfilewriter->getCode()
        );
    }

    /**
     * Test insert interface class with extends other interface
     *
     * @return void
     * @throws Exception
     */
    public function testInsertClassInterfaceWithExtends(): void
    {
        $this->phpfilewriter->insertClass('MyInterface', $this->phpfilewriter::TYPE_INTERFACE, 'AnotherInterface');

        $this->assertEquals(
            'interface MyInterface extends AnotherInterface',
            $this->phpfilewriter->getCode()
        );
    }

    /**
     * Test exception of insertClass if the implements another interface in interface instruction
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionInsertClassInterfaceWithImplements(): void
    {
        $this->expectException(Exception::class);

        $this->phpfilewriter->insertClass(
            'MyInterfaceWithImplements',
            $this->phpfilewriter::TYPE_INTERFACE,
            '',
            'AnotherInterface'
        );
    }

    /**
     * Test insert function with two arguments
     *
     * @return void
     * @throws Exception
     */
    public function testInsertFunction(): void
    {
        $this->phpfilewriter->insertFunction(
            'addition',
            $this->phpfilewriter::TYPE_FUNCTION,
            $this->phpfilewriter::VISIBILITY_PUBLIC,
            'void',
            'int $number1',
            'int $number2'
        );

        $this->assertEquals('function addition(int $number1, int $number2): void', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert function without args
     *
     * @return void
     * @throws Exception
     */
    public function testInsertFunctionWithoutArgs(): void
    {
        $this->phpfilewriter->insertFunction(
            'test',
            $this->phpfilewriter::TYPE_FUNCTION
        );

        $this->assertEquals('function test(): void', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert function without args and indicate a class method
     *
     * @return void
     * @throws Exception
     */
    public function testInsertFunctionWithoutArgsWithMethodType(): void
    {
        $this->phpfilewriter->insertFunction(
            'test',
            $this->phpfilewriter::TYPE_METHOD
        );

        $this->assertEquals('public function test(): void', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert a simple variable with an string value
     *
     * @return void
     */
    public function testInsertVariable(): void
    {
        $this->phpfilewriter->insertVariable('test', '\'A string value\'');

        $this->assertEquals('$test = \'A string value\'', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert a simple variable with an integer value
     *
     * @return void
     */
    public function testInsertVariableWithIntegerValue(): void
    {
        $this->phpfilewriter->insertVariable('test', '1235');

        $this->assertEquals('$test = 1235', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert a simple variable with an boolean value
     *
     * @return void
     */
    public function testInsertVariableWithBooleanValue(): void
    {
        $this->phpfilewriter->insertVariable('test', 'false');

        $this->assertEquals('$test = false', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert a const property with an boolean value
     *
     * @return void
     */
    public function testInsertConstPropertyWithBooleanValue(): void
    {
        $this->phpfilewriter->insertVariable('test', 'false', $this->phpfilewriter::TYPE_PROPERTY_CONST);

        $this->assertEquals('const $test = false', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert a const simple variable with an integer value
     *
     * @return void
     */
    public function testInsertConstVariableWithIntegerValue(): void
    {
        $this->phpfilewriter->insertVariable('TEST', '0x00A05', $this->phpfilewriter::TYPE_CONST);

        $this->assertEquals('define(\'TEST\', 0x00A05);', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert an open brace
     *
     * @return void
     */
    public function testInsertBrace(): void
    {
        $this->phpfilewriter->insertBrace();

        $this->assertEquals('{', $this->phpfilewriter->getCode());
    }

    /**
     * Test insert an open brace
     *
     * @return void
     */
    public function testInsertCloseBrace(): void
    {
        $this->phpfilewriter->insertBrace($this->phpfilewriter::CLOSE_BRACE);

        $this->assertEquals('}', $this->phpfilewriter->getCode());
    }

    /**
     * Test exception of insert brace
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionInsertBrace(): void
    {
        $this->expectException(Exception::class);

        $this->phpfilewriter->insertBrace($this->phpfilewriter::TYPE_CONST);
    }
}
