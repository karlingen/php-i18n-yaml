# PHP I18n YAML
Ruby on Rails inspired I18n solution for PHP applications.<br>
You can use this class together with YAML-files to accomplish translation throughout your application.

Enjoy!


## Requirements

* PHP >= 5.3
* LibYAML (only tested 0.1.5)

## Configuration
Make sure you have the following constants defined in your application somewhere:

```
DEFAULT_LOCALE = "" # the default locale.
DIR_LOCALE = ""   # full path to your locales.

```

## Example

#### test.php
```php
<?php
DEFAULT_LOCALE = "en"
DIR_LOCALE = "/var/www/config/locales/"

require_once("i18n.php") // you should probably use an autoloader

echo "Welcome ".I18N::t("user.name").". ". I18N::t("have_fun");
?>
```

#### en.yml

```yaml
en:
  have_fun: Have fun!
  user:
    name: Karl Metum

```

##### Output:
```
Welcome Karl Metum. Have fun!
```

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Added some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request