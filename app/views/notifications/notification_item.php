<?php
/**
 * File: app/views/notifications/alert.php
 * Floating Top Notification (Melayang di atas konten)
 */
if (isset($_SESSION['flash_message'])): 
    $type = $_SESSION['flash_type'] ?? 'info';
    $message = $_SESSION['flash_message'];
    
    $config = [
        'success' => [
            'class' => 'alert-success-custom',
            'title' => 'Berhasil!',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
        ],
        'danger' => [
            'class' => 'alert-danger-custom',
            'title' => 'Gagal!',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
        ],
        'warning' => [
            'class' => 'alert-warning-custom',
            'title' => 'Peringatan!',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />'
        ],
        'info' => [
            'class' => 'alert-info-custom',
            'title' => 'Informasi',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
        ]
    ];

    $current = $config[$type] ?? $config['info'];
?>

<style>
/* Container untuk menempatkan notifikasi di pojok kanan atas */
.toast-container-top-right {
    position: fixed;
    top: 25px;
    right: 25px;
    z-index: 99999;
    /* Memastikan berada di lapisan paling atas menimpa navbar/sidebar/konten */
    max-width: 380px;
    width: 100%;
    pointer-events: none;
    /* Agar area luar toast tetap bisa diklik */
}

/* Card Toast Modern */
.modern-toast {
    pointer-events: auto;
    /* Mengaktifkan klik di dalam toast */
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    padding: 1rem 1.25rem;
    position: relative;
    overflow: hidden;
    background: #ffffff;

    /* Efek animasi muncul dari atas ke bawah */
    animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    transition: all 0.3s ease;
}

/* Skema Warna Border & Text */
.alert-success-custom {
    border-left: 5px solid #22c55e;
    color: #15803d;
}

.alert-danger-custom {
    border-left: 5px solid #ef4444;
    color: #b91c1c;
}

.alert-warning-custom {
    border-left: 5px solid #f59e0b;
    color: #b45309;
}

.alert-info-custom {
    border-left: 5px solid #06b6d4;
    color: #0369a1;
}

.modern-toast .alert-icon {
    width: 24px;
    height: 24px;
    flex-shrink: 0;
}

.modern-toast .close-btn {
    background: transparent;
    border: none;
    font-size: 1.25rem;
    line-height: 1;
    opacity: 0.4;
    cursor: pointer;
    color: #000;
    transition: opacity 0.2s ease;
}

.modern-toast .close-btn:hover {
    opacity: 0.8;
}

/* Progress Bar Auto Close */
.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 100%;
    background: rgba(0, 0, 0, 0.05);
}

.toast-progress-bar {
    height: 100%;
    width: 100%;
    animation: shrink 4s linear forwards;
}

.alert-success-custom .toast-progress-bar {
    background-color: #22c55e;
}

.alert-danger-custom .toast-progress-bar {
    background-color: #ef4444;
}

.alert-warning-custom .toast-progress-bar {
    background-color: #f59e0b;
}

.alert-info-custom .toast-progress-bar {
    background-color: #06b6d4;
}

/* Keyframe Animations */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes shrink {
    from {
        width: 100%;
    }

    to {
        width: 0%;
    }
}
</style>

<!-- Floating Container -->
<div class="toast-container-top-right">
    <div class="modern-toast <?= $current['class']; ?>" id="flashAlert" role="alert">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <svg class="alert-icon mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <?= $current['icon']; ?>
                </svg>
                <div>
                    <strong class="d-block text-capitalize"
                        style="font-size: 0.9rem; line-height: 1.2;"><?= $current['title']; ?></strong>
                    <span style="font-size: 0.85rem; color: #4b5563;"><?= htmlspecialchars($message); ?></span>
                </div>
            </div>
            <button type="button" class="close-btn ml-3" onclick="closeAlert()" aria-label="Close">
                &times;
            </button>
        </div>
        <div class="toast-progress">
            <div class="toast-progress-bar"></div>
        </div>
    </div>
</div>

<script>
function closeAlert() {
    const alert = document.getElementById('flashAlert');
    if (alert) {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px) scale(0.95)';
        setTimeout(() => {
            const container = alert.parentElement;
            alert.remove();
            if (container) container.remove();
        }, 300);
    }
}

// Otomatis menutup dalam 4 detik
setTimeout(closeAlert, 4000);
</script>

<?php 
    unset($_SESSION['flash_type']);
    unset($_SESSION['flash_message']);
endif; 
?>