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
     * Return the content of generated PHP File
     *
     * @return string
     */
    public function getCode(): string
    {
        return implode('', $this->elements);
    }
}
