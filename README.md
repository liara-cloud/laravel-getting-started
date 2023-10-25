## Installation

- ```git clone https://github.com/liara-cloud/laravel-getting-started.git```
- ```cd laravel-getting-started```
- ```cp .env.example .env ```
- ```composer update --ignore-platform-reqs``` 
- Set up Database configuration inside .env file.
- ```php artisan setup``` or ```php artisan migrate --seed```
- Install all dependencies via `npm` and Compile all assets based on your deployment environment. 

```bash
#Install all dependencies
npm install

#Development
npm dev

#Production
npm prod
```

- Create symbolic link 
```
php artisan storage:link
```

- Start the local server using the command
```
php artisan serve
```

### Current Admin Credentials

You may use these credentials to log into your website. you can change these credentials shortly after logging in.

**Email** : admin@gmail.com<br>
**Password** : password

## License
[MIT](LICENSE) © Albin Varghese
