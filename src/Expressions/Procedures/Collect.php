<?php declare(strict_types=1);
/*
 * This file is part of php-cypher-dsl.
 *
 * Copyright (C) Wikibase Solutions
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WikibaseSolutions\CypherDSL\Expressions\Procedures;

use WikibaseSolutions\CypherDSL\Traits\ErrorTrait;
use WikibaseSolutions\CypherDSL\Traits\TypeTraits\PropertyTypeTraits\BooleanTypeTrait;
use WikibaseSolutions\CypherDSL\Types\AnyType;
use WikibaseSolutions\CypherDSL\Types\CompositeTypes\ListType;
use WikibaseSolutions\CypherDSL\Types\CompositeTypes\MapType;
use WikibaseSolutions\CypherDSL\Types\PropertyTypes\BooleanType;
use WikibaseSolutions\CypherDSL\Types\PropertyTypes\StringType;

/**
 * This class represents the "collect()" function.
 *
 * @see https://neo4j.com/docs/cypher-manual/current/functions/aggregating/#functions-collect Corresponding documentation on Neo4j.com
 * @see Procedure::collect()
 */
final class Collect extends Procedure implements BooleanType
{
    use BooleanTypeTrait;
    use ErrorTrait;

    /**
     * @var ListType|MapType|StringType An expression that returns a list
     */
    private AnyType $expression;

    /**
     * The signatures of the "collect()" function are:
     * - "collect(input :: LIST? OF ANY?) :: (BOOLEAN?)" - to check whether a list is empty
     * - "collect(input :: MAP?) :: (BOOLEAN?)" - to check whether a map is empty
     * - "collect(input :: STRING?) :: (BOOLEAN?)" - to check whether a string is empty.
     *
     * @param ListType|MapType|StringType $expressions An expression that returns a list
     *
     * @internal This method is not covered by the backwards compatibility promise of php-cypher-dsl
     */
    public function __construct(AnyType $expressions)
    {
        $this->expression = $expressions;
    }

    /**
     * @inheritDoc
     */
    protected function getSignature(): string
    {
        return "collect(%s)";
    }

    /**
     * @inheritDoc
     */
    protected function getParameters(): array
    {
        return [$this->expression];
    }
}
