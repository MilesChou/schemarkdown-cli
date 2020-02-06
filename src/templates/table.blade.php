<?php
/** @var \MilesChou\Docusema\Table $schema */
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

| Key | Name | Columns | Unique |
| --- | --- | --- | --- |
@foreach($schema->indexes() as $key)
| {{ $key->isPrimary() ? 'PK' : '' }} | {{ $key->getName() }} | {{ implode(',', $key->getColumns()) }} | {{ $key->isUnique() ? 'true' : 'false' }} |  |  |
@endforeach
