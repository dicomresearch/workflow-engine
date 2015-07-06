#Workflow Library


[![Codacy Badge](https://www.codacy.com/project/badge/9d8661680f414a429872bc386eda2880)](https://www.codacy.com/app/bukharovSI/workflow-engine)
[![Codeship Badge](https://codeship.com/projects/6b7255f0-0262-0133-f681-72f0e170e2d1/status?branch=master)](https://codeship.com/projects/88922)

##How to install for using

Add dependency to your project

```bash
composer require dicomresearch/workflow-engine
```

##How to install for contribute

1) Download the project

```bash
git clone git@bitbucket.org:dicomresearch/workflow-engine.git
```

2) Cd to project directory

```bash
cd workflow-engine
```

3) You must install composer global or local for this project
local installation:

```bash
curl -sS https://getcomposer.org/installer | php
```

4) install dependencies

```bash
php composer.phar install
```

5) Run tests

##How to run tests

```bash
php vendor/bin/phpunit --bootstrap vendor/autoload.php tests
```