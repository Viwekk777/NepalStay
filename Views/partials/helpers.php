<?php
if (!function_exists('ns_e')) {
    function ns_e(mixed $value): string { return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    function ns_money(mixed $value): string { return number_format((float) $value, 2); }
    function ns_date(string $value): string { try { return (new DateTimeImmutable($value))->format('d M Y'); } catch (Throwable $e) { return $value; } }
    function ns_input(array $values, string $key, string $default = ''): string { return isset($values[$key]) && is_string($values[$key]) ? $values[$key] : $default; }
    function ns_status(string $status): string { return in_array($status, ['pending', 'confirmed', 'cancelled'], true) ? $status : 'other'; }
    function ns_icon(string $name): string {
        $paths = [
            'arrow' => '<path d="M4 12h15m-6-6 6 6-6 6"/>',
            'mountain' => '<path d="m2 20 8-15 5 9 2-4 5 10H2Z"/><path d="m7 11 3 2 3-2"/>',
            'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4m10-4v4M3 11h18M7 15h3m4 0h3"/>',
            'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/>',
            'check' => '<path d="m5 12 4 4L19 6"/>',
            'leaf' => '<path d="M20 3C9 2 2 7 5 15c6 8 16 0 15-12ZM4 21 16 9"/>',
            'pin' => '<path d="M19 10c0 5-7 11-7 11S5 15 5 10a7 7 0 1 1 14 0Z"/><circle cx="12" cy="10" r="2"/>',
            'bed' => '<path d="M3 18V7m18 11V9H3m0 5h18M3 18v3m18-3v3M7 9V5h10v4"/>',
            'shield' => '<path d="m12 2 8 4v6c0 5-8 10-8 10S4 17 4 12V6l8-4Z"/><path d="m8 12 3 3 5-6"/>',
            'print' => '<path d="M7 8V3h10v5M7 17H3V8h18v9h-4M7 14h10v7H7z"/>',
        ];
        return '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($paths[$name] ?? $paths['arrow']) . '</svg>';
    }
}
