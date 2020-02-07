<?php
/** @var \MilesChou\Schemarkdown\Table $schema */
?>
# Table `{{ $schema->database() }}.{{ $schema->table() }}`

{{ $schema->comment() }}

## Columns

| Name | Type | Length | Precision | Not Null | Auto Increment | Default | Comment |
| --- | --- | --- | --- | --- | --- | --- | --- |
@foreach($schema->columns() as $column)
| {{ $column->getName() }} | {{ $column->getType()->getName() }} | {{ $column->getLength() }} | {{ $column->getPrecision() }} | {{ $column->getNotnull() ? 'true' : 'false' }} | {{ $column->getAutoincrement() ? 'true' : 'false' }} | {{ $column->getDefault() }} | {{ $column->getComment() }} |
@endforeach

## Indexes

| Name | Columns | Type |
| --- | --- | --- |
@foreach($schema->indexes() as $key)
| {{ $key->getName() }} | {{ implode(',', $key->getColumns()) }} | {{ strtoupper($key->type()) }} |
@endforeach
