Gephart Quality
===

[![Build Status](https://travis-ci.org/gephart/quality.svg?branch=master)](https://travis-ci.org/gephart/quality)

Dependencies
---
 - PHP >= 7.1
 - pdepend/pdepend = 2.5.0

Instalation
---

```
composer require gephart/quality
```

Using
---

```
$checker = new Gephart\Quality\Checker();
$checker->setDir("src");
$classes_quality = $checker->getQuality();

// Gephart\Quality\Entity\ClassQuality[]
$classes_quality[0]->getPercent(); // 100
$classes_quality[0]->getClassName(); // App\MyClass
$classes_quality[0]->getIssues(); // Gephart\Quality\Entity\Issue[]
```
