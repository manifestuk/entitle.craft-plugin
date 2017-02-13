## Entitle ##

[![Build Status](https://travis-ci.org/experience/entitle.craft-plugin.svg?branch=master)](https://travis-ci.org/experience/entitle.craft-plugin)

Entitle is a [Craft plugin][craft] which makes it easy to apply AP-style title capitalisation rules to the text on your website.

[craft]: https://craftcms.com "The CMS of choice for the Associated Press, appropriately enough"

## Requirements ##
Each release of Entitle is [automatically tested][travis] against PHP 5.5 and above. It is also manually tested on the most recent version of Craft.

[travis]: https://travis-ci.org/experience/entitle.craft-plugin "See the Entitle build status on Travis CI"

## Installation ##

1. [Download the latest release][download], and unzip it.
2. Copy the `entitle` folder to your `craft/plugins` directory.
3. Navigate to the "Admin &rarr; Settings &rarr; Plugins" page, and activate Entitle.
4. Optionally configure Entitle, as described in the next section.

[download]: https://github.com/experience/entitle.craft-plugin/releases/latest "Download the latest release"

## Configuration ##
Entitle allows you to specify "protected" words, which are not subject to the AP capitalisation rules. This is useful for ensuring that acronyms, brand names, and the like are not modified.

After installing Entitle (as described above), navigate to its settings page, and enter your "protected" words as a comma-delimited string.

## Usage ##
There are three ways to use Entitle:

- As a Craft service.
- As a template variable.
- As a Twig filter.

### Service ###
The Entitle service exposes a single method, `capitalize`. The method accepts an input string, and returns the correctly-capitalised result.

    // Result: 'Of Mice and Men'
    craft()->entitle->capitalize('of mice and men');

### Template variable ###
Entitle exposes a single template variable, `capitalize`. As with the service method of the same name, it accepts an input string, and returns the correctly-capitalised result.

    // Result: 'Fear and Loathing in Las Vegas'
    {{ craft.entitle.capitalize('fear and loathing in las vegas') }}

### Twig filter ###
Entitle exposes a single Twig filter, `entitle`.

    // Result: 'The Hound of the Baskervilles'
    {{ 'the hound of the baskervilles'|entitle }}
    
