<?php
/** @var \MilesChou\Schemarkdown\Models\Table $table */
?>
# Table `{{ $table->database() }}.{{ $table->table() }}`

{{ $table->comment() }}

## Columns

| Name | Type | Length | Precision | Not Null | Auto Increment | Default | Comment |
| --- | --- | --- | --- | --- | --- | --- | --- |
@foreach($table->columns() as $column)
| {{ $column->getName() }} | {{ $column->getType()->getName() }} | {{ $column->getLength() }} | {{ $column->getPrecision() }} | {{ $column->getNotnull() ? 'true' : 'false' }} | {{ $column->getAutoincrement() ? 'true' : 'false' }} | {{ $column->getDefault() }} | {{ $column->getComment() }} |
@endforeach

## Indexes

| Name | Columns | Type |
| --- | --- | --- |
@foreach($table->indexes() as $key)
| {{ $key->getName() }} | {{ implode(',', $key->getColumns()) }} | {{ strtoupper($key->type()) }} |
@endforeach
