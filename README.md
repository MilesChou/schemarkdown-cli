# Docusema

[![Build Status](https://travis-ci.com/MilesChou/docusema.svg?branch=master)](https://travis-ci.com/MilesChou/docusema)
[![codecov](https://codecov.io/gh/MilesChou/docusema/branch/master/graph/badge.svg)](https://codecov.io/gh/MilesChou/docusema)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/416d2087f50144e5be348825ff912936)](https://www.codacy.com/manual/MilesChou/docusema)

The database document generator for Laravel.

## Installation

Download the [Release](https://github.com/MilesChou/docusema/releases) phar file and execute it:

```bash
chmod +x docusema.phar
./docusema.phar
```

Or move into `/usr/local/bin` if want globally call:

```bash
mv docusema.phar /usr/local/bin/docusema
docusema
```

## Usage

In Laravel project, you can run this command immediately:

```bash
cd /path/to/your/project
docusema
```

Schema document are stored to `generated` directory default. Use the `--output-dir` option to change it.

In the other framework, you must provide config file like Laravel. This tool using [`hassankhan/config`](https://github.com/hassankhan/config) to load config file like PHP, JSON, YAML, etc. Use `--config-file` option to specify custom config.

This tool will load `.env` before load config. Use the `--env` option to specify .env path. 

Use the `--connection` option to specify **connection name** in Laravel config to generate document of one database.

## Example

Here is example [SQL](/examples/examples.sql), import MySQL and run following command:

```
php bin/docusema.php --config-file=tests/Fixtures/database.php --connection=examples --output-dir=examples
```

It will generate this [Markdown documents](/examples).
