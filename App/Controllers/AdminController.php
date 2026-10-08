<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Auth;
use App\Models\Booking;

class AdminController
{
    public function __construct(private Booking $booking) {}

    public function dashboard(): void
    {
        if (!Auth::check()) {
            header('Location: /login');
            return;
        }
        if (!Auth::isAdmin()) {
            http_response_code(403);
            $pageTitle = 'Access restricted';
            require __DIR__ . '/../../Views/partials/header.php';
            echo '<main id="main" class="shell section"><div class="empty-state"><h1>Account access only.</h1><p>This page is available to administrators.</p><a class="button" href="/profile">Return to your account</a></div></main>';
            require __DIR__ . '/../../Views/partials/footer.php';
            return;
        }
        $overview = $this->booking->getAdminOverview();
        $recentBookings = $this->booking->getRecentBookings();
        require __DIR__ . '/../../Views/Admin/Dashboard.php';
    }
}
