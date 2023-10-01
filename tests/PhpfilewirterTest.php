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
     * Test insret namespace instruction
     *
     * @return void
     */
    public function testInsertNamespace(): void
    {
        $this->phpfilewriter->insertNamespace('My\\Namespace');

        $this->assertEquals('namespace My\\Namespace;', $this->phpfilewriter->getCode());
    }
}
