<?php

namespace WikibaseSolutions\CypherDSL\Tests\Unit\Expressions;

use PHPUnit\Framework\TestCase;
use WikibaseSolutions\CypherDSL\Expressions\Variable;
use WikibaseSolutions\CypherDSL\Syntax\Alias;

/**
 * @covers \WikibaseSolutions\CypherDSL\Syntax\Alias
 */
class AliasTest extends TestCase
{
    private Alias $alias;

    protected function setUp(): void
    {
        parent::setUp();

        $this->alias = new Alias(
            new Variable("a"),
            new Variable("b")
        );
    }

    public function testToQuery(): void
    {
        $this->assertSame("a AS b", $this->alias->toQuery());
    }

    public function testGetOriginal(): void
    {
        $this->assertEquals(new Variable("a"), $this->alias->getOriginal());
    }

    public function testGetVariable(): void
    {
        $this->assertEquals(new Variable("b"), $this->alias->getVariable());
    }
}
