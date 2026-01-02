Write-Host "=============================="
Write-Host "VERSÕES DO PROJETO"
Write-Host "=============================="

Write-Host ""
Write-Host "PHP:"
php -v

Write-Host ""
Write-Host "Laravel:"
php artisan --version

Write-Host ""
Write-Host "Composer:"
composer --version
composer show | Select-String -Pattern "^[^ ]+" | Select-Object -First 10

Write-Host ""
Write-Host "Node.js:"
node -v

Write-Host ""
Write-Host "NPM:"
npm -v

Write-Host ""
Write-Host "Vue.js:"
npm list vue

Write-Host ""
Write-Host "Vite:"
npm list vite

Write-Host ""
Write-Host "Tailwind CSS:"
npm list tailwindcss

Write-Host ""
Write-Host "Inertia.js:"
npm list @inertiajs/inertia

Write-Host ""
Write-Host "Dependências do NPM:"
npm list --depth=0 | Select-Object -First 10

Write-Host ""
Write-Host "MySQL:"
try { mysql --version } catch { Write-Host "MySQL não encontrado." }

Write-Host ""
Write-Host "SQLite:"
try { sqlite3 --version } catch { Write-Host "SQLite não encontrado." }

Write-Host ""
Write-Host "Ficheiros de configuração:"
Write-Host " - composer.json"
Write-Host " - package.json"
Write-Host " - .env"

Write-Host ""
Write-Host "Concluído!"
