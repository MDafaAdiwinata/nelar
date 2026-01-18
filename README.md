<p align="center">
    <img src="https://skillicons.dev/icons?i=laravel" height="80" alt="laravel logo"  />
    <img width="20" />
    <img src="https://skillicons.dev/icons?i=react" height="80" alt="react logo"  />
    <img width="20" />
    <img src="https://skillicons.dev/icons?i=next" height="80" alt="react logo"  />
</p>

## CRUD - Laravel, Inertia, NextJS, Shadcn UI without Restfull API

---

## 🛠️ Tech Stack / Framework

- **Laravel** – Backend
- **PHP** – Server-side
- **Inertia.js** – Bridg
- **NextJS** – Frontend
- **TypeScript** – Type Safety
- **ShadCN UI** – UI Components
- **Tailwind CSS** – Utility-first CSS
- **Tailark** – Libary Template UI
- **MySQL** – Database Management System

---

#### # Installation Project

##### not a cloning, this is tutorial step from zero

Gunakan terminal di vscode atau lokal:

```bash
composer create-project laravel/laravel:^11 .
```

<br>

##### Custom your database
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<your database name>
DB_USERNAME=root
DB_PASSWORD=
```

<br>

```bash
composer require laravel/breeze --dev
```

```bash
php artisan breeze:install react --typescript
```

```bash
npm i
npm i -D tailwindcss postcss autoprefixer
npx shadcn@latest init
```

```bash
php artisan make:model LoremIpsum -mc
```

```bash
php artisan storage:link
```

<br>

change _Register User/Role Permisson_
open _app/Http/Controllers/Auth/RegisteredUserController.php_

```bash
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user', // Tambahkan ini - semua registrasi default user
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}
```

<br>

create _Role Permission Middleware_

```bash
php artisan make:middleware RolePermission
```

```bash
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Jika admin, redirect ke admin dashboard
            if ($user->role === 'admin' && $request->route()->getName() === 'dashboard') {
                return redirect()->route('admin.dashboard');
            }

            // Jika user biasa, redirect ke user dashboard
            if ($user->role === 'user' && $request->route()->getName() === 'dashboard') {
                return redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
```

<br>

create _DashboardController_

```bash
php artisan make:controller DashboardController
```

```bash
    public function admin()
    {
        $totalProducts = Product::count();

        return Inertia::render('Admin/Dashboard', [
            'totalProducts' => $totalProducts
        ]);
    }

    public function user()
    {
        $products = Product::latest()->get();

        return Inertia::render('User/Dashboard', [
            'products' => $products
        ]);
    }
```

<br>

change _Route Web_

```bash
// Route default dashboard (akan redirect sesuai role)
    Route::get('/dashboard', function() {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');
```

```bash
// role->admin
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // CRUD Products
    Route::resource('products', ProductController::class);
});

// role->user
Route::middleware(['auth', 'verified'])->prefix('user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'user'])->name('user.dashboard');
});
```
<br>

#### File Structure Akhir

```
your_project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   └── Middleware/
│   │       └── RolePermission.php
│   └── Models/
│       └── User.php
├── resources/
│   └── js/
│       ├── Pages/
│       │   ├── Index.tsx
│       │   ├── Admin/
│       │   │   ├── Dashboard.tsx
│       │   └── User/
│       │       └── Dashboard.tsx
│       └── components/
│           └── ui/
│               ├── button.tsx
│               ├── card.tsx
│               ├── input.tsx
│               └── ...
├── routes/
│   └── web.php
└── storage/
    └── app/
        └── public/
```
<br>

#### Note
untuk lebih dalam memahami Logic CRUD di Controller, open ProductController in Repo Github here, di sana sudah di sediakan logic CRUD dengan code dibuat sederhana, hingga mudah untuk di pahami dan di kembangkan.

dan Selalu perhatikan struktur folder seperti Admin/Products agar sesuai dengan route Web yang ada di repo project ini, disesuaikan saja dengan kebutuhan anda.

<br>

Running the Project

```bash
npm run dev
```
```bash
php artisan serve
```
<br>

### Lisensi
Project ini dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).

Anda diperbolehkan untuk menggunakan, menyalin, dan memodifikasi proyek ini sesuai dengan ketentuan lisensi tersebut.

Namun, dilarang keras untuk:

- Mengklaim proyek atau aset sebagai milik pribadi tanpa atribusi yang semestinya;

- Memperjualbelikan aset proyek ini secara langsung maupun tidak langsung;

- Menyalahgunakan aset proyek untuk tujuan yang melanggar hukum atau merugikan pihak lain.

Setiap bentuk pelanggaran terhadap ketentuan di atas dapat dikenakan tindakan hukum sesuai dengan peraturan perundang-undangan yang berlaku. 
<br>

**BIJAK DALAM BERKARYA!**