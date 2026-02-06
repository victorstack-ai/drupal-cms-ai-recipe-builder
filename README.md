# Drupal CMS AI Recipe Builder

A small recipe starter plus a PHP blueprint helper for AI-driven site building experiments in Drupal CMS (Starshot).

## What's here

- `recipe.yml`: A starter recipe that installs baseline content-building modules and creates an `AI Builder` role.
- `src/RecipeBlueprint.php`: A tiny helper to generate a recipe YAML from a JSON payload.
- `bin/build-recipe.php`: CLI that updates `recipe.yml` from a JSON blueprint.
- `examples/ai-site-builder.json`: Example blueprint payload.

## Using the recipe

1. Copy `recipe.yml` into your Drupal CMS installation (for example `recipes/ai-site-builder/recipe.yml`).
2. Apply it with a recipe runner (`drush recipe recipes/ai-site-builder` or `php core/scripts/drupal recipe recipes/ai-site-builder`).

## Updating the recipe via the blueprint

```bash
composer install
php bin/build-recipe.php examples/ai-site-builder.json
```

## Why this exists

Drupal CMS recipes are designed to bundle configuration and module installs into repeatable site-building steps. This repo pairs a starter recipe with a minimal blueprint helper so AI or human planners can quickly emit a recipe YAML from structured inputs.

## License

MIT
