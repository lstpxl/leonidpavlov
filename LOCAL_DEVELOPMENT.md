### Configure Apache server on Mac

```
/opt/homebrew/etc/httpd/httpd.conf
```

Include /opt/homebrew/etc/httpd/extra/httpd-vhosts.conf

sudo apachectl restart


### Or run PHP command-line

```
php -S localhost:8000 -t ~/Projects/armario
```
