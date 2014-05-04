task/process
============

[![Build Status](https://travis-ci.org/taskphp/phpunit.svg?branch=master)](https://travis-ci.org/taskphp/process)
[![Coverage Status](https://coveralls.io/repos/taskphp/phpunit/badge.png?branch=master)](https://coveralls.io/r/taskphp/process?branch=master)

Installation
============

Install via Composer:
```json
...
    "require-dev": {
        "task/process": "~0.2"
    }
...
```

Usage
=====

Inject into the project container:
```php
use Task\Plugin\ProcessPlugin;

$project->inject(function ($container) {
    $container['ps'] = new ProcessPlugin;
});

$project->addTask('whoami', ['ps', function ($ps) {
    $ps->run('whoami')->pipe($this->getOutput());
}]);
```

API
===

```php
run($command, array $args = [], $cwd = null, array $env = [], OutputInterface $output = null)
```

`$command` - The command run:
```php
run('whoami');
```
`array $args = []` - An array of command line arguments:
```php
run('ls', ['-la']);
```
`$cwd = null` - The directory to execute the command in:
```php
run('du', ['-hs'], '/path/to/my/project');
```
`$env` - An array of environment variables:
```php
run('myscript', [], null, ['DEBUG' => 1]);
```

```php
build($command, array $args = [])
```

Accepts the same `$command` and `$args` arguments as run, but returns an instance of `Task\Plugin\Process\ProcessBuilder`, which thinly wraps Symfony's `ProcessBuilder`, providing an OO interface to confguration a command.
