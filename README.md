# Schemarkdown CLI 

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

See [schemarkdown](https://github.com/MilesChou/schemarkdown) for more information.

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

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
