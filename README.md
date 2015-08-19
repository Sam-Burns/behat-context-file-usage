Behat Context File Usage
========================

Produces an HTML code coverage report, showing you which parts of your Behat Context files are actually being used, and
what can be deleted.  Useful for the maintenance of larger suites.

Uses PHPUnit's coverage report generator.

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

It makes your test suite run slower, so maybe just use it now and again.  Take the stuff back out of the `behat.yml` to
turn it off.
