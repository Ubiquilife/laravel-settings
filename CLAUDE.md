# CLAUDE.md — laravel-settings

## Overview

Ubiquilife fork of anlutro/l4-settings. Provides persistent key-value settings storage with multiple backends (database, JSON file, memory). Used across all Ubiquilife apps for app, organisation, and user-scoped settings.

## Namespace

`anlutro\LaravelSettings`

## Key Classes

- **`SettingStore`** — Abstract base. Defines `get()`, `set()`, `forget()`, `has()`, `all()`, `save()`.
- **`DatabaseSettingStore`** — Stores settings in a database table. Supports extra columns for scoping.
- **`JsonSettingStore`** — Stores settings in a JSON file on disk.
- **`MemorySettingStore`** — In-memory store (testing).
- **`SettingsManager`** — Laravel Manager that resolves the configured store.
- **`Facade`** / **`Facades\Setting`** — `Setting::get('key')`, `Setting::set('key', 'value')`.
- **`SaveMiddleware`** — HTTP middleware that auto-saves dirty settings at end of request.
- **`ServiceProvider`** — Auto-discovered. Registers manager, facade, middleware, and migration.
- **`helpers.php`** — Global `setting()` helper function.

## Configuration

Store driver and table name in `config/settings.php`.

## Testing

```bash
cd laravel-settings && vendor/bin/phpunit
```

## Mandatory Rules

- This is a PRIVATE Ubiquilife package. Changes affect ALL apps.
- NEVER change the `SettingStore` interface or database schema without checking all consuming apps.
- Settings support hierarchical scopes (app > organisation > user, with per-feature overrides). Do not break this precedence.
- Use British spelling in all text and comments.
- Test before committing.
- One logical change per commit.
