#!/bin/bash

set -e

# Matikan semua MPM
a2dismod mpm_event 2>/dev/null || true
a2dismod mpm_worker 2>/dev/null || true
a2dismod mpm_prefork 2>/dev/null || true

# Aktifkan HANYA prefork
a2enmod mpm_prefork

# Laravel membutuhkan rewrite
a2enmod rewrite

# Cek konfigurasi Apache sebelum dijalankan
apache2ctl -t

# Jalankan Apache
exec apache2-foreground