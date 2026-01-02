ARCHIVED! Moved to https://sogvin.com/php-logger

[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=gregoryv&url=https%3A%2F%2Fgithub.com%2Fgregoryv%2Fphp-logger&title=php-logger&language=php&tags=github&category=software)

* [API reference](http://gregoryv.github.io/php-logger/api/namespace-gregoryv.logger.html)
* [Example](ExampleUsage.php)

README
======

Logger module for basic intuitive logging in php. Severity levels are based on
those for *syslog* found in [RFC5424](http://tools.ietf.org/html/rfc5424).
This module is a starting point from which you can evolve your logging needs
as your system grows. The simplest and default way of using it is

    use gregoryv\logger\Logger;

    $log = new Logger();
    $log->info('something');

    $x = 'something';
    $log->debugf('Variable $x=%s', $x);

    $log->turn('off debug'); // for this logger only
    $log->debug('this will not be written');

    $log->turn('off all warn'); // for this and all subsequently created loggers


The logger has methods for each severity level defined by [RFC5424 6.2.1](http://tools.ietf.org/html/rfc5424#section-6.2.1).
That means you do not care much about where the messages end up initially, which
surprisingly, is in the syslog.

![Design](design.jpg)

Usage
-----

Add to your composer.json

    {
      "require": {
        "gregoryv/php-logger": "*"
      }
    }
