# INSTALLATION

```bash
composer install
```

# Load fixtures

```bash
php bin/console doctrine:fixtures:load
```

# PROJECT

This project is a test about the usage of the symfony FormType with a dynamic select field.
I used the event listener to update the form after the selection of the first field. (PRE_SET_DATA event, POST_SUBMIT event)
And add some JavaScript to update the form after the selection of the country field for update the city field according to the country selected.