# Schemarkdown

[![Build Status](https://travis-ci.com/MilesChou/schemarkdown.svg?branch=master)](https://travis-ci.com/MilesChou/schemarkdown)
[![codecov](https://codecov.io/gh/MilesChou/schemarkdown/branch/master/graph/badge.svg)](https://codecov.io/gh/MilesChou/schemarkdown)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/8e858d7ebc494a7db0f3c9a92f40a72e)](https://www.codacy.com/manual/MilesChou/schemarkdown)
[![Latest Stable Version](https://poser.pugx.org/MilesChou/schemarkdown/v/stable)](https://packagist.org/packages/MilesChou/schemarkdown)
[![Total Downloads](https://poser.pugx.org/MilesChou/schemarkdown/d/total.svg)](https://packagist.org/packages/MilesChou/schemarkdown)
[![License](https://poser.pugx.org/MilesChou/schemarkdown/license)](https://packagist.org/packages/MilesChou/schemarkdown)

The database document generator for Laravel.

## Installation

Download the [Release](https://github.com/MilesChou/schemarkdown/releases) phar file and execute it:

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

In Laravel project, you can run this command immediately:

```bash
cd /path/to/your/project
schemarkdown
```

Schema document are stored to `generated` directory default. Use the `--output-dir` option to change it.

In the other framework, you must provide config file like Laravel. This tool using [`hassankhan/config`](https://github.com/hassankhan/config) to load config file like PHP, JSON, YAML, etc. Use `--config-file` option to specify custom config.

This tool will load `.env` before load config. Use the `--env` option to specify .env path. 

Use the `--connection` option to specify **connection name** in Laravel config to generate document of one database.

## Example

Here is example [SQL](/examples/examples.sql), import MySQL and run following command:

```
php bin/schemarkdown.php --config-file=tests/Fixtures/database.php --connection=examples --output-dir=examples
```

It will generate this [Markdown documents](/examples).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
