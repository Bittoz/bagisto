# Bagisto Project - Bittoz

This is a secure deployment of Bagisto on shared hosting.

## Structure

- `/bagisto-app` — Laravel core application
- `/public_html` — Only contains `index.php`, `.htaccess`, and public assets

## Deployment Notes

`index.php` is modified to point to `../bagisto-app/vendor/autoload.php`  
and `../bagisto-app/bootstrap/app.php`
