# Schemarkdown

[![Release](https://github.com/MilesChou/schemarkdown-cli/actions/workflows/release.yml/badge.svg)](https://github.com/MilesChou/schemarkdown-cli/actions/workflows/release.yml)
[![tests](https://github.com/MilesChou/schemarkdown-cli/actions/workflows/tests.yml/badge.svg)](https://github.com/MilesChou/schemarkdown-cli/actions/workflows/tests.yml)

The schema document generator and eloquent model generator for CLI, only.

Use the [schemarkdown](https://github.com/MilesChou/schemarkdown) library.

## Installation

Download the [Release](https://github.com/MilesChou/schemarkdown-cli/releases) phar file and execute it:

```bash
chmod +x schemarkdown.phar
./schemarkdown.phar
```

Or move into `/usr/local/bin` if want globally call:

```bash
mv schemarkdown.phar /usr/local/bin/schemarkdown
schemarkdown
```

## Usage

### `schema:markdown`

In Laravel project, you can run this command immediately:

```bash
cd /path/to/your/project
schemarkdown schema:markdown
```

Schema document are stored to `docs` directory default. Use the `--output-dir` option to change it.

In the other framework, you must provide config file like Laravel. Use `--config-file` option to specify customize configuration.

This tool will load `.env` before load config. Use the `--env` option to specify .env path. 

Use the `--connection` option to specify **connection name** in Laravel config to generate the document of one database.

Use the `--overwrite` option if you want to overwrite the exists document.

### `schema:model`

Just like `schema:markdown`, run this command directly:

```bash
cd /path/to/your-laravel-project
schemarkdown schema:model
```

It's will generate model code into `app/Models` directory (Laravel 8 default), use the `--output-dir` option can change output dir. If want to change namespace, use the `--namespace` option.

In the other framework but using Eloquent ORM library, you must provide config file like laravel project. Use `--config-file` option to specify customize configuration.

If only want build one connection, use the `--connection` option to specify.

Use the `--overwrite` option if you want to overwrite exist code.

## Example

Here is example [SQL](/examples/examples.sql), import MySQL and run following command:

```
php schemarkdown.phar --config-file=tests/Fixtures/database.php --connection=examples --output-dir=examples
```

It will generate this [Markdown documents](/examples).

## Build Yourself

Clone this repository and run `make` command:

```bash
make
```

Use [Box](https://github.com/box-project/box) to build PHAR file:

```
box compile
```

## Troubleshooting

Use `-vv` option to see info log.

### Memory limit errors

Schemarkdown respects a memory limit defined by the `MEMORY_LIMIT` environment variable:

```
MEMORY_LIMIT=-1 schemarkdown
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
