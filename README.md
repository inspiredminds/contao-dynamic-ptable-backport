Contao Dynamic Ptable Backport
==============================

This Contao extension backports the support for automatic dynamic parent tables to Contao 4.9. This is a feature that was added to Contao in Contao 4.10 (see [this PR](https://github.com/contao/contao/pull/1446)). This enables you to utilise `tl_content` as the child table for your own table for example, without having to manualy set the `ptable` in the DCA of `tl_content` dynamically yourself.
