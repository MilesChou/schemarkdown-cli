<?php
/** @var \MilesChou\Schemarkdown\Models\Schema $schema */
?>
# Database `{{ $schema->database() }}`

## Tables

@foreach($schema->tables() as $table)
* [{{ $table }}]({{ \Illuminate\Support\Str::snake($table) }}.md)
@endforeach
