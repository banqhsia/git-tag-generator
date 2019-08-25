# Git tag generator

Git-tag-generator is a tool that can help you generate release tag conveniently.

![Demonstration](https://user-images.githubusercontent.com/4393788/63652488-43048380-c793-11e9-8819-8ff5e9988538.png)

## Installation

```bash
$ composer require global benyi/git-tag-generator:dev-master
```

## Usage

* Basic usage
    ```bash
    $ git-tag-generator [--repo <path>] [--next <identifier> [--create]]
    ```
* Get next tag
    ```bash
    $ git-tag-generator --next patch
    ```
* Create the tag
    ```bash
    $ git-tag-generator --next patch --create
    ```
