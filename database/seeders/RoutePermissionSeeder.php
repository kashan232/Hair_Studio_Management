<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoutePermissionSeeder extends Seeder
{
    private const GUARD = 'web';

    private const EXCLUDED = [
        'login',
        'register',
        'password.request',
        'password.email',
        'password.reset',
        'password.store',
        'verification.notice',
        'verification.verify',
        'verification.send',
        // Laravel public disk / filesystem (not app permissions)
        'storage.local',
        'storage.local.upload',
    ];

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->removeDuplicatePermissionNames();
        $this->removeStoragePermissions();

        $created = 0;
        $updated = 0;

        foreach ($this->collectRoutePermissions() as $permissionName => $model) {
            $permission = Permission::query()->firstOrNew([
                'name' => $permissionName,
                'guard_name' => self::GUARD,
            ]);

            $isNew = ! $permission->exists;
            $permission->model = $model;
            $permission->save();

            if ($isNew) {
                $created++;
            } elseif ($permission->wasChanged()) {
                $updated++;
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $total = Permission::where('guard_name', self::GUARD)->count();
        $this->command?->info("Route permissions synced: {$created} created, {$updated} updated ({$total} total).");

        $superAdmin = Role::where('name', 'super-admin')->where('guard_name', self::GUARD)->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::where('guard_name', self::GUARD)->get());
            $this->command?->info('All permissions assigned to super-admin role.');
        }
    }

    private function removeDuplicatePermissionNames(): void
    {
        $removed = Permission::query()
            ->where('guard_name', self::GUARD)
            ->where(function ($query) {
                $query->where('name', 'like', '%.store')
                    ->orWhere('name', 'like', '%.confirm-delete');
            })
            ->delete();

        if ($removed > 0) {
            $this->command?->warn("Removed {$removed} duplicate .store / .confirm-delete permissions.");
        }
    }

    private function removeStoragePermissions(): void
    {
        $removed = Permission::query()
            ->where('guard_name', self::GUARD)
            ->where(function ($query) {
                $query->where('name', 'storage')
                    ->orWhere('name', 'like', 'storage.%');
            })
            ->delete();

        if ($removed > 0) {
            $this->command?->warn("Removed {$removed} storage filesystem permissions.");
        }
    }

    private function isExcludedRoute(string $routeName): bool
    {
        if (in_array($routeName, self::EXCLUDED, true)) {
            return true;
        }

        if ($routeName === 'storage' || str_starts_with($routeName, 'storage.')) {
            return true;
        }

        return str_starts_with($routeName, 'ignition.')
            || str_starts_with($routeName, 'livewire.')
            || str_starts_with($routeName, 'sanctum.');
    }

    /**
     * @return array<string, string> canonical permission name => model group
     */
    private function collectRoutePermissions(): array
    {
        $permissions = [];

        foreach (Route::getRoutes() as $route) {
            $routeName = $route->getName();

            if ($routeName === null || $this->isExcludedRoute($routeName)) {
                continue;
            }

            $permissionName = $this->canonicalPermissionName($routeName);

            if ($permissionName === null) {
                continue;
            }

            $permissions[$permissionName] = $this->modelGroupForRoute($permissionName);
        }

        ksort($permissions);

        return $permissions;
    }

    /**
     * .store → .create (single permission)
     * .confirm-delete → skipped (.destroy covers it)
     */
    private function canonicalPermissionName(string $routeName): ?string
    {
        if (str_ends_with($routeName, '.confirm-delete')) {
            return null;
        }

        if (str_ends_with($routeName, '.store')) {
            return preg_replace('/\.store$/', '.create', $routeName);
        }

        return $routeName;
    }

    private function modelGroupForRoute(string $permissionName): string
    {
        if (! str_contains($permissionName, '.')) {
            return match ($permissionName) {
                'users' => 'users',
                'roles' => 'roles',
                'permissions' => 'permissions',
                default => $permissionName,
            };
        }

        [$segment] = explode('.', $permissionName, 2);

        return match ($segment) {
            'user' => 'users',
            'role' => 'roles',
            'permission' => 'permissions',
            default => $segment,
        };
    }
}
