DIRECTORY STRUCTURE
-------------------

      bundle/                       contains simple symfony project with bundle
        \ --->command-chaining/     contains simple command-chaining bundle configurated by clients services.yaml 
# Configuration:

bundles.php: <br>
    `Dr10s\CommandChaining\CommandChainingBundle::class => ['all' => true],`

services.yaml: Mark your chains by example:
```  
master:command:name:
    class: Dr10s\App\Command\MasterCommand
    tags:
        - { name: chain_item, item: Dr10s\App\Command\ChainCommand }
        - { name: chain_item, item: Dr10s\App\Command\ChainCommand }

```

<b>Warning:</b><br>
`master:command:name` must be equals with `$masterCommand->getName()`

<br><b>PS:</b><br>
Sorry, but we have no tests. <br>
Sorry, but we have no test bundles, i`m just use Symfony project for run as example.
