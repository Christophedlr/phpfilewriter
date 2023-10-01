<?php

namespace Christophedlr\Phpfilewriter;

use Exception;

class Phpfilewriter
{
    public const START_TAG = 0;
    public const END_TAG = 1;
    public const TYPE_ABSTRACT = 'abstract';
    public const TYPE_INTERFACE = 'interface';

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
     * Insert an namespace instruction
     *
     * @param string $namespace
     * @return $this
     */
    public function insertNamespace(string $namespace): Phpfilewriter
    {
        $this->elements[] = 'namespace ' . $namespace . ';';

        return $this;
    }

    /**
     * Insert an class instruction
     *
     * @param string $FQDN
     * @param string $type
     * @return $this
     * @throws Exception
     */
    public function insertClass(
        string $FQDN,
        string $type = '',
        string $extends = '',
        string $implements = ''
    ): Phpfilewriter {
        $class = '';

        if ($type === $this::TYPE_INTERFACE && !empty($implements)) {
            throw new Exception('insertClass - Interface does not used implements instruction');
        }

        if (empty($type)) {
            $class = 'class';
        } elseif ($type === $this::TYPE_INTERFACE) {
            $class = 'interface';
        } elseif ($type === $this::TYPE_ABSTRACT) {
            $class = 'abstract class';
        } else {
            throw  new Exception('insertClass - Bad value of type');
        }

        $this->elements[] = $class . ' ' . $FQDN . (!empty($extends) ? ' extends ' . $extends : '') .
            (!empty($implements) ? ' implements ' . $implements : '');

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
