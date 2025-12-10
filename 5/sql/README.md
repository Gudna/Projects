DB schema for Quản lý Bảo hiểm Xe

Canonical SQL file: `sql/qlbh_xe.sql`

How to import locally (Windows / PowerShell):

1. Make sure MySQL/MariaDB `mysql` client is in your PATH. For XAMPP default, it is `C:\\xampp\\mysql\\bin`.

2. Run the import script from the `sql` folder (example uses empty root password):

```powershell
cd C:\\xampp\\htdocs\\FProjects\\5\\sql
.\import-db.ps1 -User root -Password "" -Database qlbh_xe -SqlFile "C:\\xampp\\htdocs\\FProjects\\5\\sql\\qlbh_xe.sql"
```

If you prefer to import directly with mysql client, run:

```powershell
mysql -u root -p qlbh_xe < "C:\\xampp\\htdocs\\FProjects\\5\\sql\\qlbh_xe.sql"
```

Notes:

- The SQL includes triggers and sample data.
- The project's DB config is in `config/config.php`. Confirm `DB_USER`, `DB_PASS`, `DB_NAME` before importing.
- If you need me to import automatically I can (requires running the mysql client here).
