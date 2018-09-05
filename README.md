# Puml: an PHP UML generator [![Build Status](https://travis-ci.org/DannyvdSluijs/puml.png)](https://travis-ci.org/DannyvdSluijs/puml)

Puml is an PHP UML generator, which aids in reverse enginering and in a refactoring process. It allows you to generate the UML scheme for an object. Given that you take care of the autoloader.

## Features
* Multiple outputs (PNG, DOT)
* Inheritance support

## Author
* [Danny van der Sluijs](http://www.dannyvandersluijs.nl) (Creator, Developer)

## License
* [New BSD license](http://www.opensource.org/licenses/bsd-license.php)

## Todo
* Add support for additional outputs

## Requirements
* Most of the dependencies are handled by [composer](http://getcomposer.org). There are some requirements not handled by composer.
  * dot - graphviz version. You can check this with `dot -V`

## Installing
* This package is available on [packagist.org](https://packagist.org/packages/dannyvdsluijs/puml), and can be installed by adding the following to you composer.json
``
{
    ...
    "require": {
        ...
        "dannyvdsluijs/puml": "dev-master"
        ...
    }
}

## Contributing

## Further information
