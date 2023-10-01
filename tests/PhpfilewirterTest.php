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
}
