<?php

declare(strict_types=1);

use VictorStackAi\DrupalCmsAiRecipeBuilder\RecipeBlueprint;

require __DIR__ . '/../vendor/autoload.php';

$input = $argv[1] ?? '';
if ($input === '' || !is_file($input)) {
    fwrite(STDERR, "Usage: php bin/build-recipe.php <json-file>\n");
    exit(1);
}

$payload = json_decode((string) file_get_contents($input), true);
if (!is_array($payload)) {
    fwrite(STDERR, "Invalid JSON payload.\n");
    exit(1);
}

$blueprint = RecipeBlueprint::fromArray($payload);
file_put_contents(__DIR__ . '/../recipe.yml', $blueprint->toYaml());

fwrite(STDOUT, "recipe.yml updated.\n");
