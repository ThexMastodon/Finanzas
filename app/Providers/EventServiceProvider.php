<?php

namespace App\Providers;

use App\Models\Modulo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event to listener mappings for the application.
   *
   * @var array<class-string, array<int, class-string>>
   */
  protected $listen = [
    Registered::class => [
      SendEmailVerificationNotification::class,
    ],
  ];

  /**
   * Register any events for your application.
   */
  public function boot(): void
  {
    Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
      $userPermissions = Auth::check() ? Auth::user()->roles->pluck('permissions')->flatten()->pluck('name')->toArray() : [];
      $modulos = Modulo::with([
        'submodulos.permisos' => function ($query) {
          $query->whereHas('tipoPermiso', function ($query) {
            $query->where('id_s', 'C');
          });
        },
        'permisos' => function ($query) {
          $query->whereHas('tipoPermiso', function ($query) {
            $query->where('id_s', 'C');
          });
        }
      ])
        ->whereHas('permisos', function ($query) use ($userPermissions) {
          $query->whereIn('name', $userPermissions);
        })
        ->orWhereHas('submodulos.permisos', function ($query) use ($userPermissions) {
          $query->whereIn('name', $userPermissions);
        })
        ->get();
      // Construir el menú dinámico
      $menu = [];

      foreach ($modulos as $modulo) {
        // Agregar los permisos del módulo (sin submódulos)
        $moduloItem = [
          'text' => trans($modulo->nombre),
          'icon' => $modulo->icono,
          'icon_color' => $modulo->color_icono,
          'route' => isset($modulo->ruta) && Route::has($modulo->ruta) ? $modulo->ruta : null,
        ];

        $moduloPermisos = $modulo->permisos ? $modulo->permisos->pluck('name')->toArray() : [];

        if (!empty($moduloPermisos)) {
          $moduloItem['can'] = $moduloPermisos;
        }

        // Agregar los permisos de los submódulos
        if ($modulo->submodulos->isNotEmpty()) {
          $submenu = [];

          foreach ($modulo->submodulos as $submodulo) {
            $permisos = [];
            foreach ($submodulo->permisos as $permiso) {
              $permisos[] = [
                'text' => trans($submodulo->nombre),
                'icon' => $submodulo->icono,
                'icon_color' => $submodulo->color_icono,
                'can' => $permiso->name,
                'route' => isset($submodulo->ruta) && Route::has($submodulo->ruta) ? $submodulo->ruta : null,
              ];
            }

            if (!empty($permisos)) {
              // Si el submódulo tiene más de un permiso, agregarlo directamente al submenú
              if (count($permisos) > 1) {
                $submenu = array_merge($submenu, $permisos);
              } else {
                $submenu[] = $permisos[0]; // Si solo tiene un permiso, agregarlo como submódulo
              }
            }
          }

          if (!empty($submenu)) {
            $moduloItem['submenu'] = $submenu;
          }
        }

        $menu[] = $moduloItem;
      }

      $event->menu->add(...$menu);
    });
  }

  /**
   * Determine if events and listeners should be automatically discovered.
   */
  public function shouldDiscoverEvents(): bool
  {
    return false;
  }
}
