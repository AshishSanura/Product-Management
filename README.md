# Product-Management

### Project Setup Follow Step

## 1. Clone the Repository
git clone https://github.com/AshishSanura/Product-Management.git
cd Product-Management

## 2. Configure Database
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=

# BROADCASTING & PUSHER
BROADCAST_DRIVER=pusher

# Local Pusher / Websockets
VITE_PUSHER_APP_KEY=entr_your_key
VITE_PUSHER_APP_CLUSTER=entr_your_cluster
VITE_PUSHER_HOST=127.0.0.1
VITE_PUSHER_PORT=6001
VITE_PUSHER_SCHEME=entr_your_scheme

PUSHER_APP_ID=2044459
PUSHER_APP_KEY=ff12b5c0f5831967c59e
PUSHER_APP_SECRET=7c5afe7b7a9c50e33577
PUSHER_APP_CLUSTER=ap2

PUSHER_HOST=${VITE_PUSHER_HOST}
PUSHER_PORT=${VITE_PUSHER_PORT}
PUSHER_SCHEME=${VITE_PUSHER_SCHEME}
PUSHER_APP_CLUSTER=${VITE_PUSHER_APP_CLUSTER}

# WEBPUSH VAPID KEYS
VAPID_PUBLIC_KEY=entr_your_public_key
VAPID_PRIVATE_KEY=entr_your_private_key
VAPID_SUBJECT=mailto:enter your mail

## 3. Install Dependencies
composer install
npm install
npm run dev

## 4. Run Migrations and Seeders
php artisan migrate
php artisan db:seed

php artisan storage:link 
php artisan queue:work (Product Import time Command afetr Product Import)