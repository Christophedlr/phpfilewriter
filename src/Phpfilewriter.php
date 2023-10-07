<?php

namespace Christophedlr\Phpfilewriter;

use Exception;

class Phpfilewriter
{
    public const START_TAG = 0;
    public const END_TAG = 1;
    public const TYPE_ABSTRACT = 'abstract';
    public const TYPE_INTERFACE = 'interface';
    public const TYPE_FUNCTION = 0x10;
    public const TYPE_METHOD = 0x11;
    public const VISIBILITY_PUBLIC = 0x20;
    public const VISIBILITY_PRIVATE = 0x21;
    public const VISIBILITY_PROTECTED = 0x22;
    public const TYPE_VARIABLE = 0x30;
    public const TYPE_PROPERTY_CONST = 0x31;
    public const TYPE_CONST = 0x32;
    public const OPEN_BRACE = 0x03;
    public const CLOSE_BRACE = 0x04;

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
     * Insert a function/method instruction
     *
     * @param string $name
     * @param int $type
     * @param string $visibility
     * @param string $returnType
     * @param string ...$args
     * @return $this
     * @throws Exception
     */
    public function insertFunction(
        string $name,
        int $type = Phpfilewriter::TYPE_FUNCTION,
        string $visibility = Phpfilewriter::VISIBILITY_PUBLIC,
        string $returnType = 'void',
        string ...$args
    ): Phpfilewriter {
        $element = '';

        if ($type === Phpfilewriter::TYPE_METHOD) {
            if ($visibility == Phpfilewriter::VISIBILITY_PUBLIC) {
                $element .= 'public function';
            } elseif ($visibility == Phpfilewriter::VISIBILITY_PRIVATE) {
                $element .= 'private function';
            } elseif ($visibility == Phpfilewriter::VISIBILITY_PROTECTED) {
                $element .= 'protected function';
            } else {
                throw new Exception('insertFunction - Invalid visibility type');
            }
        } elseif ($type === Phpfilewriter::TYPE_FUNCTION) {
            $element .= 'function';
        } else {
            throw new Exception('insertFunction - Type invalid');
        }

        $element .= ' ' . $name . '(' . implode($args, ', ') . ')';

        if (!empty($returnType)) {
            $element .= ': ' . $returnType;
        }

        $this->elements[] = $element;

        return $this;
    }

    public function insertVariable(string $name, string $value, int $type = Phpfilewriter::TYPE_VARIABLE): Phpfilewriter
    {
        $element = '';

        if ($type === Phpfilewriter::TYPE_PROPERTY_CONST) {
            $this->elements[] = 'const $' . $name . ' = ' . $value;
        } elseif ($type === Phpfilewriter::TYPE_CONST) {
            $this->elements[] = 'define(\'' . $name . '\', ' . $value . ');';
        } elseif ($type === Phpfilewriter::TYPE_VARIABLE) {
            $this->elements[] = '$' . $name . ' = ' . $value;
        } else {
            throw new Exception('insertVariable - Type is invalid');
        }

        return $this;
    }

    /**
     * Insert an open or close brace
     *
     * @param int $type
     * @return $this
     * @throws Exception
     */
    public function insertBrace(int $type = Phpfilewriter::OPEN_BRACE): Phpfilewriter
    {
        if ($type === Phpfilewriter::OPEN_BRACE) {
            $this->elements[] = '{';
        } elseif ($type === Phpfilewriter::CLOSE_BRACE) {
            $this->elements[] = '}';
        } else {
            throw new Exception('insertBrace - Type is invalid');
        }

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
