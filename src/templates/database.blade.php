<?php
/** @var \MilesChou\Docusema\Database $database */
?>
# Database `{{ $database->database() }}`

## Tables

@foreach($database->tables() as $table)
* [{{ $table }}]({{ \Illuminate\Support\Str::snake($table) }}.md)
@endforeach
