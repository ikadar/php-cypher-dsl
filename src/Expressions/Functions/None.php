<?php

namespace WikibaseSolutions\CypherDSL\Expressions\Functions;

use WikibaseSolutions\CypherDSL\Expressions\Expression;

class None extends FunctionCall
{
    private Expression $variable;
    private Expression $list;
    private Expression $predicate;

    /**
     * @param Expression $variable
     * @param Expression $list
     * @param Expression $predicate
     */
    public function __construct(Expression $variable, Expression $list, Expression $predicate)
    {
        $this->variable = $variable;
        $this->list = $list;
        $this->predicate = $predicate;
    }


    /**
     * @inheritDoc
     */
    protected function getSignature(): string
    {
        return "none(%s IN %s WHERE %s)";
    }

    /**
     * @inheritDoc
     */
    protected function getParameters(): array
    {
        return [$this->variable, $this->list, $this->predicate];
    }
}