NOTES
* Semua file migration ada di projek desktop saja (Biar terpusat)
* Jadi jalanin migrationnya cukup dari project desktop saja (Mobile, webservice tidak perlu)
* Path file migration : /protected/migrations

RULES (Kesepakatan Developer)
* Tiap perubahan kolom di satu tabel yang sama cukup ditaruh di satu file migration 
* Jika ada perubahan kolom di tabel yang berbeda, maka dibuat file migration terpisah

LOCAL ENVIRONMENT
* Tiap developer buat file migration & run migration sendiri-sendiri
* Step :
* 1. Git pull. Biar semua file migration developer lain ada di projek kita
* 2. Buka terminal. Pergi ke dalam folder : /protected/
* 3. Run command : 'php yiic migrate' atau 'yes | php yiic migrate' (Untuk langsung jalanin tanpa perlu klik konfirmasi Yes)

STAGING ENVIRONMENT
* File migration di local push ke Gitlab
* Build. Script 'yes | php yiic migrate' sudah otomatis di run ketika kita build project desktop

PRODUCTION ENVIRONMENT
* Developer HARUS memastikan file migration yg dibuat jalan di local masing-masing
* Infra run manual lewat terminal 'php yiic migrate'

USAGE
  yiic migrate [action] [parameter]

DESCRIPTION
  This command provides support for database migrations. The optional
  'action' parameter specifies which specific migration task to perform.
  It can take these values: up, down, to, create, history, new, mark.
  If the 'action' parameter is not given, it defaults to 'up'.
  Each action takes different parameters. Their usage can be found in
  the following examples.

EXAMPLES
* yiic migrate
  Applies ALL new migrations. This is equivalent to 'yiic migrate up'.

* yiic migrate create create_user_table
  Creates a new migration named 'create_user_table'.

* yiic migrate up 3
  Applies the next 3 new migrations.

* yiic migrate down
  Reverts the last applied migration.

* yiic migrate down 3
  Reverts the last 3 applied migrations.

* yiic migrate to 101129_185401
  Migrates up or down to version 101129_185401.

* yiic migrate mark 101129_185401
  Modifies the migration history up or down to version 101129_185401.
  No actual migration will be performed.

* yiic migrate history
  Shows all previously applied migration information.

* yiic migrate history 10
  Shows the last 10 applied migrations.

* yiic migrate new
  Shows all new migrations.

* yiic migrate new 10
  Shows the next 10 migrations that have not been applied.
   


