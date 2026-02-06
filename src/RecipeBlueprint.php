<?php

declare(strict_types=1);

namespace VictorStackAi\DrupalCmsAiRecipeBuilder;

final class RecipeBlueprint
{
    /** @var string[] */
    private array $modules;

    /** @var string[] */
    private array $permissions;

    public function __construct(
        private readonly string $name,
        private readonly string $description,
        private readonly string $type,
        array $modules,
        array $permissions,
        private readonly string $roleId = 'ai_builder',
        private readonly string $roleLabel = 'AI Builder',
        private readonly string $siteName = 'AI Site Builder Demo',
    ) {
        $this->modules = $this->normalizeList($modules);
        $this->permissions = $this->normalizeList($permissions);
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            (string) ($payload['name'] ?? 'AI Site Builder Starter'),
            (string) ($payload['description'] ?? 'Baseline modules and roles for AI-assisted site building.'),
            (string) ($payload['type'] ?? 'Site building'),
            (array) ($payload['modules'] ?? []),
            (array) ($payload['permissions'] ?? []),
            (string) ($payload['role_id'] ?? 'ai_builder'),
            (string) ($payload['role_label'] ?? 'AI Builder'),
            (string) ($payload['site_name'] ?? 'AI Site Builder Demo'),
        );
    }

    public function toYaml(): string
    {
        $lines = [];
        $lines[] = "name: '" . $this->escape($this->name) . "'";
        $lines[] = "description: '" . $this->escape($this->description) . "'";
        $lines[] = "type: '" . $this->escape($this->type) . "'";
        $lines[] = 'install:';
        foreach ($this->modules as $module) {
            $lines[] = '  - ' . $module;
        }
        $lines[] = 'config:';
        $lines[] = '  actions:';
        $lines[] = '    user.role.' . $this->roleId . ':';
        $lines[] = '      createIfNotExists:';
        $lines[] = '        id: ' . $this->roleId;
        $lines[] = "        label: '" . $this->escape($this->roleLabel) . "'";
        $lines[] = '        weight: 3';
        $lines[] = '      grantPermissions:';
        foreach ($this->permissions as $permission) {
            $lines[] = "        - '" . $this->escape($permission) . "'";
        }
        $lines[] = '    system.site:';
        $lines[] = '      simpleConfigUpdate:';
        $lines[] = "        name: '" . $this->escape($this->siteName) . "'";

        return implode("\n", $lines) . "\n";
    }

    /** @return string[] */
    private function normalizeList(array $items): array
    {
        $normalized = [];
        foreach ($items as $item) {
            $value = trim((string) $item);
            if ($value !== '') {
                $normalized[] = $value;
            }
        }

        return array_values(array_unique($normalized));
    }

    private function escape(string $value): string
    {
        return str_replace("'", "''", $value);
    }
}
