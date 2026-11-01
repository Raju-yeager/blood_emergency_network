1. Upload these files to repo root (replace existing).
2. Put DB code from config/db_aiven_example.php into your real DB config file.
3. Import database/*.sql into Aiven MySQL (use MySQL Workbench / DBeaver / mysql CLI).
4. Render > New Web Service > connect repo > Runtime: Docker.
5. Add env vars: DB_HOST, DB_PORT, DB_USER, DB_PASS, DB_NAME (from Aiven).
6. In Aiven, allow Render's IPs (or 0.0.0.0/0) under allowed IP addresses.
