To setup environment and run the application:
1. clone the repository with git clone
2. cd /barometer/barometer-app
3. run command 'composer install'
4. run command 'cp .env.example .env'
5. run command 'php artisan key:generate'
8. cd /resources
9.  run command 'npm install'
10.  cd ..
11.  run command 'docker compose up -build'
12.  then stop this docker service with ctrl(or cmd on mac) + c
13.  run command 'docker compose up db'
14.  in other terminal from /barometer-app run command 'php artisan serve'
15.  in other terminal run command 'npm run dev'
16.  open in web browser on http://localhost:8000
