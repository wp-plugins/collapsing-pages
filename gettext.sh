#!/bin/sh
xgettext --keyword=__ --keyword=_e  --default-domain=collapsing-pages --language=php *.php
mv collapsing-pages.po collapsing-pages.pot

