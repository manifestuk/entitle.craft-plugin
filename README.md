## Entitle

[![Build Status](https://travis-ci.org/experience/entitle.craft-plugin.svg?branch=master)](https://travis-ci.org/experience/entitle.craft-plugin)

Entitle is a [Craft plugin][craft] which makes it easy to apply AP-style title capitalisation rules to the text on your website.

[craft]: https://craftcms.com "The CMS of choice for the Associated Press, appropriately enough"

## Requirements
Each release of Entitle is [automatically tested][travis] against PHP 7.1 and above. It's also manually tested on the most recent version of Craft.

[travis]: https://travis-ci.org/experience/entitle.craft-plugin "See the Entitle build status on Travis CI"

### PHP 7.0 support
In theory, Entitle should be compatible with PHP 7.0. In practise, it's impossible to test this, because the Codeception dependency tree includes components which only work with PHP 7.1+.

Unfortunately there's nothing we can do about that.

## Installation
To install Entitle, either search for "Entitle" in the Craft Plugin Store, or add it as a [Composer][composer] dependency.

[composer]: https://getcomposer.org "Composer is a PHP dependency manager"

Here's how to install Entitle using Composer.

1. Open your terminal, and navigate to your Craft project:

        cd /path/to/project

2. Add Entitle as a project dependency:

        composer require experience/entitle

3. In the Control Panel, go to "Settings → Plugins", and click the "Install" button for Entitle

## Configuration
Entitle allows you to specify "protected" words, which are not subject to the AP capitalisation rules. This is useful for ensuring that acronyms, brand names, and the like are not modified.

After installing Entitle (as described above), navigate to its settings page, and enter your "protected" words as a comma-delimited string.

## Usage
There are three ways to use Entitle:

- As a Craft service.
- As a template variable.
- As a Twig filter.

### Service
The Entitle service exposes a single method, `capitalize`. The method accepts an input string, and returns the correctly-capitalised result.

    // Result: 'Of Mice and Men'
    Entitle::getInstance()->entitle->capitalize('of mice and men');

### Template variable
Entitle exposes a single template variable, `capitalize`. As with the service method of the same name, it accepts an input string, and returns the correctly-capitalised result.

    // Result: 'Fear and Loathing in Las Vegas'
    {{ craft.entitle.capitalize('fear and loathing in las vegas') }}

### Twig filter
Entitle exposes a single Twig filter, `entitle`.

    // Result: 'The Hound of the Baskervilles'
    {{ 'the hound of the baskervilles'|entitle }}
