# Smalldb Annotations

Docblock Annotations Parser library based on [Doctrine Annotations](https://github.com/doctrine/annotations).

The motivation for this fork of Doctrine Annotations is to ease the implementation
of backwards-incompatible features which are difficult to incorporate in such a widely used library. 

**Added features:**

  - Support for Class constant annotations --- see `Reader::getConstantAnnotations()`.
  
  - `RecursiveAnnotationReader` collects annotations from parent classes in addition to the given class
    and returns the list of all annotations sorted from the oldest ancestor to the requested class.
  
**Removed features:**

  - All caching readers are removed, because the annotations are further processed
    and the final result should be cached.

  - `AnnotationRegistry` is removed as well in favor of the use of standard PHP autoloader.


## Documentation

See the [doctrine-project website](https://www.doctrine-project.org/projects/doctrine-annotations/en/latest/index.html).

## Contributing

When making a pull request, make sure your changes follow the
[Coding Standard Guidelines](https://www.doctrine-project.org/projects/doctrine-coding-standard/en/latest/reference/index.html#introduction).

## Changelog

See [CHANGELOG.md](CHANGELOG.md).
