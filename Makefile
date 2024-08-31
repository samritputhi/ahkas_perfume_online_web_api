ide-helper:
	php artisan clear-compiled
	php artisan ide-helper:generate
	php artisan ide-helper:meta
	# php artisan ide-helper:models --nowrite

clear-cache:
	php artisan clear-compiled
	php artisan cache:clear
	php artisan view:clear
	php artisan config:clear
	#php artisan debugbar:clear
	php artisan event:clear
	php artisan optimize:clear
	php artisan route:clear
