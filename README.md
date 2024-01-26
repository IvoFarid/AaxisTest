REQUIREMENTS:
  _This App uses Symfony 7. It requires +PHP8.2.
  _This App uses PosgreSQL version +14. 
STEPS:
1) Clone this repo into a folder.
2) Move to the cloned folder.
3) run 'composer install' in your terminal to install all dependencies needed.
4) configure ENV. Add this values and configure it to your needs.
  # APP_ENV=dev
  # APP_SECRET=anysecret
  # DATABASE_URL="postgresql://YOUR_POSTGRE_USER:YOUR_POSTGRE_PASSWORD@127.0.0.1:5432/DATABASENAME?serverVersion=16&charset=utf8"
  _Change those values to your user, your password, the name you want for the DB, etc.
5) run 'php bin/console doctrine:database:create' in your terminal to create the DB.
6) run 'php bin/console doctrine:migrations:migrate' to run the migrations.
7) run 'symfony server:start' to start the project.
