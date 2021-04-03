<?php

namespace Database\Seeders;

use App\Http\Core\Models\Permission;
use App\Http\Core\Models\Role;
use App\Http\Core\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class LaratrustSeeder extends Seeder
{
     const ROLE_MAP = [
        'super_administrator' => ['ادمین کل '],
        'moderator' => ['ارزیاب'],
        'user' => ['کاربر'],
    ];
    //make sure that it dont have any space
     const PERMISSIONS_MAP = [
        'attributes'              =>['ویژگی'],
        'balance'              => ['تسوبه_حساب'],
        'bills'              => ['فاکتور'],
        'comment'              => ['نظر'],
        'category' => ['دسته_بندی_مطلب'],
        'coupon'              => ['کوپن'],
        'city'           => ['شهر'],
        'dashboard'         => ['داشبورد'],
        'disapproves'              => ['رددرخواست'],
        'place'              => ['شهر'],
        'document'             => ['مدارک'],
        'gateway'             => ['درگاه_بانکی'],
        'image'           => ['تصویر'],
        'message'              => ['پیام_تیکت'],
        'notification' => ['پیام'],
        'permissions'        => ['حق_دسترسی'],
        'point'              => ['امتیاز'],
        'question'              => ['سوال'],
        'role'              => ['سمت'],
        'setting'           => ['تنظیمات'],
        'shop'           => ['فروشگاه'],
        'slider'       => ['اسلایدر'],
        'takhfif'            => ['تخفیف'],
        'tickets'            => ['تیکت'],
        'transaction'              => ['تراکنش'],
        'violation'              => ['تخلف'],
        'users'             => ['کاربران'],
        'uploads'             => ['آپلودها'],
    ];
     const ACT_MAP = [
        'create' => ['ایجاد'],
        'read' => ['خواندن'],
        'update' => ['به روز رسانی'],
        'delete' => ['حذف'],
    ];

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        $this->truncateLaratrustTables();

        $config = config('laratrust_seeder.role_structure');
        $userPermission = config('laratrust_seeder.permission_structure');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $key => $modules) {

            // Create a new role
            $role = Role::create([
                'name' => $key,
                'display_name' => ucwords(str_replace('_', ' ', self::ROLE_MAP[$key][0])),
                'description' => ucwords(str_replace('_', ' ', self::ROLE_MAP[$key][0]))
            ]);
            $permissions = [];

            $this->command->info('Creating Role ' . strtoupper($key));

            // Reading role permission modules
            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {

                    $permissionValue = $mapPermission->get($perm);

                    $permissions[] = Permission::firstOrCreate([
                        'name' => $permissionValue . '-' . $module,
                        'display_name' => self::ACT_MAP[$permissionValue][0] . ' ' . self::PERMISSIONS_MAP [$module][0],
                        'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                    ])->id;

                    $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
                }
            }

            // Attach all permissions to the role
            $role->permissions()->sync($permissions);

            $this->command->info("Creating '{$key}' user");

            // Create default user for each role

            $user = User::create([
                'first_name' => ucwords(str_replace('_', ' ', self::ROLE_MAP [$key][0])),
                'mobile' => '0' . rand(9130000000, 9130000009),
                'affiliate_code' => Str::random(5),
                'password' => bcrypt('password')
            ]);

            $user->attachRole($role);
        }

        // Creating user with permissions
        if (!empty($userPermission)) {

            foreach ($userPermission as $key => $modules) {

                foreach ($modules as $module => $value) {

                    // Create default user for each permission set
                    $user = User::create([
                        'first_name' => ucwords(str_replace('_', ' ', $key)),
                        'mobile' => '0' . rand(9130000010, 9130000999),
                        'affiliate_code' => Str::random(5),
                        'password' => bcrypt('password'),
                        'remember_token' => Str::random(10),
                    ]);
                    $permissions = [];

                    foreach (explode(',', $value) as $p => $perm) {

                        $permissionValue = $mapPermission->get($perm);

                        $permissions[] = Permission::firstOrCreate([
                            'name' => $permissionValue . '-' . $module,
                            'display_name' => self::ACT_MAP[$permissionValue][0] . ' ' . self::PERMISSIONS_MAP [$module][0],
                            'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        ])->id;

                        $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
                    }
                }

                // Attach all permissions to the user
                $user->permissions()->sync($permissions);
            }
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return    void
     */
    public function truncateLaratrustTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
//        User::truncate();
        Role::truncate();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
