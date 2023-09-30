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
     * Test insert mutliple new line
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
}
