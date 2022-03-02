<?php

/*
 * Cypher DSL
 * Copyright (C) 2021  Wikibase Solutions
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

namespace WikibaseSolutions\CypherDSL\Tests\Unit\Clauses;

use PHPUnit\Framework\TestCase;
use TypeError;
use WikibaseSolutions\CypherDSL\Assignment;
use WikibaseSolutions\CypherDSL\Clauses\OptionalMatchClause;
use WikibaseSolutions\CypherDSL\Patterns\Pattern;
use WikibaseSolutions\CypherDSL\Tests\Unit\TestHelper;
use WikibaseSolutions\CypherDSL\Types\AnyType;
use WikibaseSolutions\CypherDSL\Types\StructuralTypes\NodeType;
use WikibaseSolutions\CypherDSL\Types\StructuralTypes\PathType;
use WikibaseSolutions\CypherDSL\Types\StructuralTypes\StructuralType;

/**
 * @covers \WikibaseSolutions\CypherDSL\Clauses\OptionalMatchClause
 */
class OptionalMatchTest extends TestCase
{
    use TestHelper;

    public function testEmptyClause(): void
    {
        $match = new OptionalMatchClause();

        $this->assertSame("", $match->toQuery());
        $this->assertEquals([], $match->getPatterns());
    }

    public function testSinglePattern(): void
    {
        $match = new OptionalMatchClause();
        $pattern = $this->getQueryConvertableMock(StructuralType::class, "(a)");
        $match->addPattern($pattern);

        $this->assertSame("OPTIONAL MATCH (a)", $match->toQuery());
        $this->assertEquals([$pattern], $match->getPatterns());
    }

    public function testMultiplePatterns(): void
    {
        $match = new OptionalMatchClause();
        $patternA = $this->getQueryConvertableMock(StructuralType::class, "(a)");
        $patternB = $this->getQueryConvertableMock(StructuralType::class, "(b)");

        $match->addPattern($patternA);
        $match->addPattern($patternB);

        $this->assertSame("OPTIONAL MATCH (a), (b)", $match->toQuery());
        $this->assertEquals([$patternA, $patternB], $match->getPatterns());
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testAcceptsNodeType(): void
    {
        $match = new OptionalMatchClause();
        $match->addPattern($this->getQueryConvertableMock(NodeType::class, "(a)"));

        $match->toQuery();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testAcceptsPathType(): void
    {
        $match = new OptionalMatchClause();
        $match->addPattern($this->getQueryConvertableMock(PathType::class, "(a)"));

        $match->toQuery();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testAcceptsAssignment(): void
    {
        $match = new OptionalMatchClause();
        $match->addPattern($this->getQueryConvertableMock(Assignment::class, "p = (a)-->(b)"));

        $match->toQuery();
    }

    public function testDoesNotAcceptAnyType(): void
    {
        $match = new OptionalMatchClause();

        $this->expectException(TypeError::class);

        $match->addPattern($this->getQueryConvertableMock(AnyType::class, "(a)"));

        $match->toQuery();
    }
}
