## Dishtansya Exam Project
Steps to run this project locally

1. Clone
2. Run the following commands
    - composer install
    - composer dumpautoload
3. Copy .env_example as .env. Configure the database credentials base on your local database credential.
4. Run the followwing commands
    - composer update *optional
    - php artisan key:generate
    - php artisa migrate
    - php artisan db:seed
    - php artisan passport:install
    - npm install && npm run dev

Note: Email credentials are already set up. I used my dummy email for this test.
if the steps has a flow please contact me bryanjadeloplop@gmail.com
