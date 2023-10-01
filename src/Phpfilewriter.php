<?php

namespace Christophedlr\Phpfilewriter;

use Exception;

class Phpfilewriter
{
    public const START_TAG = 0;
    public const END_TAG = 1;

    /**
     * @var array
     */
    private $elements = [];

    /**
     * Insert a PHP tag
     *
     * @param int $openclose
     * @return $this
     * @throws Exception
     */
    public function insertTag(int $openclose = Phpfilewriter::START_TAG): Phpfilewriter
    {
        if ($openclose === Phpfilewriter::START_TAG) {
            $this->elements[] = '<?php';
        } elseif ($openclose === Phpfilewriter::END_TAG) {
            $this->elements[] = '?>';
        } else {
            throw new Exception('insertTag - Value not recognized');
        }

        return $this;
    }

    /**
     * Insert a new line
     *
     * @param int $nbr
     * @return $this
     * @throws Exception
     */
    public function insertNl(int $nbr = 1): Phpfilewriter
    {
        if ($nbr >= 1) {
            $this->elements[] = str_pad('', $nbr, PHP_EOL);
        } else {
            throw new Exception('insertNl - Minimal insert a one new line');
        }

        return $this;
    }

    /**
     * Insert an indentation
     *
     * @param int $nbr
     * @param int $indentation
     * @return $this
     */
    public function insertIndentation(int $nbr = 1, int $indentation = 4): Phpfilewriter
    {
        $this->elements[] = str_pad('', $nbr * $indentation, ' ');

        return $this;
    }

    /**
     * Insert an use instruction
     *
     * @param string $class
     * @param string $as
     * @return $this
     */
    public function insertUse(string $class, string $as = ''): Phpfilewriter
    {
        $this->elements[] = 'use ' . $class . (!empty($as) ? ' as ' . $as : '') . ';';

        return $this;
    }

    /**
     * Return the content of generated PHP File
     *
     * @return string
     */
    public function getCode(): string
    {
        return implode('', $this->elements);
    }
}
