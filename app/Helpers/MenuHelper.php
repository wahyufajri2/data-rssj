<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class MenuHelper
{
    public static function getMenuGroups(): array
    {
        if (!Auth::check()) {
            return [];
        }

        $role = self::getUserRole();

        if ($role === 'superadmin') {
            return self::superadminMenus();
        }

        if ($role === 'admin_ranting') {
            return self::adminRantingMenus();
        }

        return [];
    }

    private static function getUserRole(): ?string
    {
        if (!Auth::check()) {
            return null;
        }
        return Auth::user()->role;
    }

    private static function superadminMenus(): array
    {
        return [
            [
                'title' => 'Menu Utama',
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'icon' => 'dashboard',
                        'path' => route('dashboard', [], false),
                    ],
                    [
                        'name' => 'Data Pendataan',
                        'icon' => 'pasien',
                        'path' => '#',
                        'subItems' => [
                            [
                                'name' => 'Ranting Siaga Sehat Jiwa',
                                'path' => route('pendataan.index', [], false),
                            ],
                            [
                                'name' => 'Kuesioner Mandiri',
                                'path' => route('kuesioner.index', [], false),
                            ],
                        ]
                    ],
                    [
                        'name' => 'Unduh Data',
                        'icon' => 'download',
                        'path' => route('downloads.index', [], false),
                    ],
                    [
                        'name' => 'Menu Pengaturan',
                        'icon' => 'users',
                        'path' => '#',
                        'subItems' => [
                            [
                                'name' => 'Pengguna',
                                'path' => route('superadmin.users.index', [], false),
                            ],
                            [
                                'name' => 'Periode',
                                'path' => route('superadmin.periode.index', [], false),
                            ],
                        ]
                    ],
                ],
            ],
        ];
    }

    private static function adminRantingMenus(): array
    {
        return [
            [
                'title' => 'Menu Utama',
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'icon' => 'dashboard',
                        'path' => route('dashboard', [], false),
                    ],
                    [
                        'name' => 'Data Pendataan',
                        'icon' => 'pasien',
                        'path' => '#',
                        'subItems' => [
                            [
                                'name' => 'Ranting Siaga Sehat Jiwa',
                                'path' => route('pendataan.index', [], false),
                            ],
                            [
                                'name' => 'Kuesioner Mandiri',
                                'path' => route('kuesioner.index', [], false),
                            ],
                        ]
                    ],
                    [
                        'name' => 'Unduh Data',
                        'icon' => 'download',
                        'path' => route('downloads.index', [], false),
                    ],
                ],
            ],
        ];
    }

    public static function getIconSvg(string $icon): string
    {
        return match ($icon) {
            'dashboard' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>',
            'users' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>',
            'pasien' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>',
            'pertanyaan' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>',
            'histori' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
            'download' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>',
            default => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" /></svg>',
        };
    }
}
