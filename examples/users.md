# Table `examples.users`

User registration table

## Columns

| Name | Type | Length | Precision | Not Null | Auto Increment | Default | Comment |
| --- | --- | --- | --- | --- | --- | --- | --- |
| id | integer |  | 10 | true | true |  |  |
| name | string | 255 | 10 | true | false |  | Display name |
| email | string | 255 | 10 | true | false |  | Email and login identity |
| password | string | 255 | 10 | true | false |  | SHA256 digest |
| created_at | datetime | 0 | 10 | false | false |  |  |
| updated_at | datetime | 0 | 10 | false | false |  |  |

## Indexes

| Name | Columns | Type |
| --- | --- | --- |
| email | email | UNIQUE |
| PRIMARY | id | PRIMARY |
