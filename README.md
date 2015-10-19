Behat Context File Usage
========================

What it's for
-------------

Produces an HTML code coverage report, showing you which parts of your Behat Context files are actually being used, and
what can be deleted.  Useful for the maintenance of larger suites.

Uses PHPUnit's coverage report generator.

How to install it
-----------------

Configure the extension in your `behat.yml` file, like this:

```yaml
default:
    extensions:
        BehatContextFileUsage\Extension:
            context_folder: 'tests/behat/context-files/'
            report_folder:  'tests/behat/behat-code-usage-report/'
```

You can install it by putting this in your `composer.json` file:

```json
"require": {
    "sam-burns/behat-context-file-usage": "*"
}
```

Now just run Behat as normal, with that config file.

Caveats
-------

It makes your test suite run slower, so maybe just use it now and again.  Take the stuff back out of the `behat.yml` to
turn it off.

It has not escaped the author's attention that the tool could be used to provide a PHPUnit-style code coverage report of
your actual production code, with regards to Behat test coverage.  This would be done by changing the `context_folder`
setting to a value like `src/`.  This is not a recommended approach with Behat.
