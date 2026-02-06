<?php

declare(strict_types=1);

namespace VictorStackAi\DrupalCmsAiRecipeBuilder\Tests;

use PHPUnit\Framework\TestCase;
use VictorStackAi\DrupalCmsAiRecipeBuilder\RecipeBlueprint;

final class RecipeBlueprintTest extends TestCase
{
    public function testGeneratesYamlWithModulesAndPermissions(): void
    {
        $blueprint = new RecipeBlueprint(
            'AI Site Builder Starter',
            'Baseline modules and roles for AI-assisted site building.',
            'Site building',
            ['node', 'text', 'field'],
            ['access content', 'administer nodes']
        );

        $yaml = $blueprint->toYaml();

        $this->assertStringContainsString("name: 'AI Site Builder Starter'", $yaml);
        $this->assertStringContainsString('  - node', $yaml);
        $this->assertStringContainsString("        - 'access content'", $yaml);
        $this->assertStringContainsString('    system.site:', $yaml);
    }

    public function testNormalizesDuplicateValues(): void
    {
        $blueprint = new RecipeBlueprint(
            'AI Site Builder Starter',
            'Baseline modules and roles for AI-assisted site building.',
            'Site building',
            ['node', 'node', ' text '],
            ['access content', 'access content']
        );

        $yaml = $blueprint->toYaml();

        $this->assertSame(1, substr_count($yaml, "  - node"));
        $this->assertSame(1, substr_count($yaml, "        - 'access content'"));
    }
}
