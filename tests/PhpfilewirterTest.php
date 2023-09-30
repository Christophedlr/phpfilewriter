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
}
