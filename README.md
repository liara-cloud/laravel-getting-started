## Installation

```bash
git clone https://github.com/liara-cloud/laravel-getting-started.git
```

 ```bash
 cd laravel-getting-started
 ```

 ```bash
cp .env.example .env
 ```
 ```bash
 composer update --ignore-platform-reqs
 ``` 
- Set up Database configuration inside .env file.
```bash
php artisan migrate --seed
```
- Install all dependencies via `npm` and Compile all assets based on your deployment environment. 

```bash
#Install all dependencies
npm install

#Development
npm run dev

#Production
npm run prod
```

- Create symbolic link 

```bash
php artisan storage:link
```

- Start the local server using the command
```bash
php artisan serve
```

### Current Admin Credentials

You may use these credentials to log into your website. you can change these credentials shortly after logging in.

**Email** : admin@gmail.com<br>
**Password** : password

## first look of this social media
<img src="https://files.liara.ir/liara/laravel/cource/first-look-of-social-media-laravel.png" alt="Alt text" title="Optional title">
