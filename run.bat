@echo on
cd /d "%~dp0app\public"
echo Current directory is:
cd
echo Running WP-CLI script...
"C:\Program Files\Local\resources\extraResources\bin\local-wp.exe" --path="%~dp0app\public" cli wp eval-file wp-content/themes/cuevas-theme/cli-add-products.php
echo Error level: %errorlevel%
pause
exit 