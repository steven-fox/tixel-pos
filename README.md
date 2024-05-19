# Tixel Pizza
A fantastically flavorful tech challenge. 😅

# Run Locally
Run the following commands from the project's root directory:

_Install dependencies and build the frontend._
```bash
> composer install
> npm install
> npm run build
```

If necessary, create your `.env` file from `.env.example`, configure your database, and then run migrations with the seeder.
```bash
> php artisan migrate:fresh --seed
```

_In a long running terminal, run a queue worker and start Reverb._
```bash
> php artisan queue:work & php artisan reverb:start
```

Access the app via your local setup's convention. I use Herd/Valet, so I just visit `http://tixel-pos.test`.
